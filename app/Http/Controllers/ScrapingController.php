<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ScrapingController extends Controller
{

    public function index()
    {
        // Lógica do método index
        return view('admin.products.index');
    }
    public function scrape()
    {
        // Definir a URL base de busca no Mercado Livre
        $baseUrl = 'https://www.mercadolivre.com.br/ofertas?container_id=MLB779362-1&page=';

        // Definir o número de páginas a serem percorridas
        $totalPages = 2; // Ajuste conforme necessário

        for ($page = 1; $page <= $totalPages; $page++) {
            // Construir a URL da página atual
            $url = $baseUrl . $page;

            // Obter o HTML da página usando file_get_contents
            $html = file_get_contents($url);

            // Verificar se a requisição foi bem-sucedida
            if ($html === FALSE) {
                die('Erro ao acessar a URL: ' . $url);
            }

            // Criar um novo DOMDocument
            $dom = new \DOMDocument();

            // Carregar o HTML (suprimir warnings devido a tags malformadas)
            @$dom->loadHTML($html);

            // Criar um DOMXPath para navegar no DOM
            $xpath = new \DOMXPath($dom);

            // Encontrar os títulos dos produtos
            $names = $xpath->query("//div[contains(@class, 'promotion-item__description')]//p[contains(@class, 'promotion-item__title')]");
            // Encontrar os preços antigos dos produtos
            $oldPrices = $xpath->query("//div[contains(@class, 'promotion-item__discount-component')]//s[contains(@class, 'andes-money-amount__fraction')]");
            // Encontrar os preços novos dos produtos
            $newPrices = $xpath->query("//div[contains(@class, 'promotion-item__discount-component')]//div[contains(@class, 'andes-money-amount-combo__main-container')]//span[contains(@class, 'andes-money-amount__fraction')]");

            // Verificar se encontramos títulos e preços
            if ($names->length === 0 || $oldPrices->length === 0 || $newPrices->length === 0) {
                continue; // Pular para a próxima página se não encontrar produtos
            }

            // Iterar sobre os títulos e preços e salvar no banco de dados
            for ($i = 0; $i < $names->length; $i++) {
                $name = $names->item($i)->nodeValue;
                $oldPrice = $oldPrices->item($i)->nodeValue;
                $newPrice = $newPrices->item($i)->nodeValue;

                // Criar um novo produto e salvar no banco de dados
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

            // Adicionar cabeçalhos das colunas
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