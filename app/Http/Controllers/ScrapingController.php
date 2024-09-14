<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ScrapingController extends Controller
{

    public function index()
    {
        return view('admin.products.index');
    }
    public function scrape()
    {
        $baseUrl = 'https://www.mercadolivre.com.br/ofertas?container_id=MLB779362-1&page=';

        $totalPages = 2;

        for ($page = 1; $page <= $totalPages; $page++) {
            $url = $baseUrl . $page;

            $html = file_get_contents($url);

            if ($html === FALSE) {
                die('Erro ao acessar a URL: ' . $url);
            }

            $dom = new \DOMDocument();

            @$dom->loadHTML($html);

            $xpath = new \DOMXPath($dom);

            $names = $xpath->query("//div[contains(@class, 'promotion-item__description')]//p[contains(@class, 'promotion-item__title')]");
            $oldPrices = $xpath->query("//div[contains(@class, 'promotion-item__discount-component')]//s[contains(@class, 'andes-money-amount__fraction')]");
            $newPrices = $xpath->query("//div[contains(@class, 'promotion-item__discount-component')]//div[contains(@class, 'andes-money-amount-combo__main-container')]//span[contains(@class, 'andes-money-amount__fraction')]");

            if ($names->length === 0 || $oldPrices->length === 0 || $newPrices->length === 0) {
                continue;
            }

            for ($i = 0; $i < $names->length; $i++) {
                $name = $names->item($i)->nodeValue;
                $oldPrice = $oldPrices->item($i)->nodeValue;
                $newPrice = $newPrices->item($i)->nodeValue;

                $product = new Product();
                $product->name = $name;
                $product->old_price = $oldPrice;
                $product->new_price = $newPrice;
                $product->save();
            }
        }

        return response()->json(['message' => 'Scraping concluído com sucesso']);
    }

    public function exportCsv()
    {
        $products = Product::all();

        $response = new StreamedResponse(function() use ($products) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Nome', 'Preço Antigo', 'Preço Novo']);

            foreach ($products as $product) {
                fputcsv($handle, [
                    $product->name,
                    $product->old_price,
                    $product->new_price
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="products.csv"');

        return $response;
    }
}