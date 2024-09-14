<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ScrapingController extends Controller
{
    public function scrape()
    {
        // Definir a URL de busca no Mercado Livre
        $url = 'https://www.mercadolivre.com.br/';

        // Obter o HTML da página usando file_get_contents
        $html = file_get_contents($url);

        // Verificar se a requisição foi bem-sucedida
        if ($html === FALSE) {
            die('Erro ao acessar a URL');
        }

        // Criar um novo DOMDocument
        $dom = new \DOMDocument();

        // Carregar o HTML (suprimir warnings devido a tags malformadas)
        @$dom->loadHTML($html);

        // Criar um DOMXPath para navegar no DOM
        $xpath = new \DOMXPath($dom);

       // Encontrar os títulos dos produtos
       $titles = $xpath->query('//a[contains(@class, "poly-component__title")]');
       $prices = $xpath->query('//div[contains(@class, "poly-price__current")]//span[contains(@class, "andes-money-amount__fraction")]');
       $types = $xpath->query('//div[contains(@class, "ui-recommendations-title-link")]');

        // Verificar se encontramos títulos e preços
        if ($titles->length === 0 || $prices->length === 0) {
            die('Nenhum produto encontrado');
        }

        // Iterar sobre os títulos, preços e tipos e salvar no banco de dados
        for ($i = 0; $i < $titles->length; $i++) {
            $title = $titles->item($i)->nodeValue;
            $price = $prices->item($i)->nodeValue;
            $type = $types->length > $i ? $types->item($i)->nodeValue : 'Desconhecido';

            // Criar um novo produto e salvar no banco de dados
            $product = new Product();
            $product->title = $title;
            $product->price = $price;
            $product->type = $type; // Adicionando o tipo do produto
            $product->save();
        }

        return response()->json(['message' => 'Scraping concluído com sucesso']);
    }

    // Método para listar os produtos armazenados no banco de dados
    public function index()
    {
        // Buscar todos os produtos do banco de dados
        $products = Product::all();

        // Retornar a view com os produtos
        return view('products.index', ['products' => $products]);
    }

    public function exportCsv()
    {
        $products = Product::all();

        $csvData = "Title,Price,Type\n";

        foreach ($products as $product) {
            $csvData .= "{$product->title},{$product->price},{$product->type}\n";
        }

        $fileName = 'products_' . date('Ymd_His') . '.csv';

        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename={$fileName}");
    }
}
