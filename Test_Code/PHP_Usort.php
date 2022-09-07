<?php

interface Sellable
{
    public function __construct(string $sku, array $categoryNames, bool $inStock);
    public function getSku(): string;
    public function getCategoryNames(): array;
    public function isInStock(): bool;
}

class Product implements Sellable
{
    protected $sku;
    protected $categoryNames;
    protected $inStock;
    
    public function __construct(string $sku, array $categoryNames, bool $inStock) 
    {
      $this->sku = $sku;
      $this->categoryNames = $categoryNames;
      $this->inStock = $inStock;
    }
    
    public function getSku(): string
    {
        return $this->sku;
    }
    
    public function getCategoryNames(): array
    {
        return $this->categoryNames;
    }
    
    public function isInStock(): bool
    {
        return $this->inStock;
    }
}


class Catalog
{
    /**
     * @var array
     */
    protected $catalog;
    protected $stock;

    function sortByStock($a, $b) {
      if ($a['stock'] == $b['stock']) {
        return 0;
      }
      return ($a['stock'] > $b['stock']) ? -1 : 1;
    }

    function sortByCat($a, $b) {
      return strcmp($a['cat'], $b['cat']);
    }

    function sortBySku($a, $b) {
      return strcmp($a['sku'], $b['sku']);
    }

    public function addToCatalog(Product $product)
    {
        $sku = $product->getSku();
        $categories = $product->getCategoryNames();
        $isInStock = $product->isInStock();

        foreach ($categories as $value) {
          $this->stock[] = [ 'sku' => $sku, 'cat' => $value, 'stock' => $isInStock];
        }
        
        return $this;
    }

    /**
     * @return array
     */
    public function renderCatalog()
    {

      usort($this->stock, array("Catalog", "sortByCat"));
      usort($this->stock, array("Catalog", "sortBySku"));
      usort($this->stock, array("Catalog", "sortByStock"));

      foreach ($this->stock as $key => $value) {
        if (array_key_exists($value['cat'], $this->catalog)) {
          array_push($this->catalog[$value['cat']], $value['sku']);
        } else {
          $this->catalog[$value['cat']] = [ $value['sku'] ];
        }
      }

      ksort($this->catalog);
      return $this->catalog;
    }
}

$products = [
    new Product('LAPTOP', ['electronics', 'computers'], false),
    new Product('VIDEO_RECORDER', ['electronics', 'audio/video'], true),
    new Product('CAMERA', ['electronics', 'audio/video'], true)
];

$catalog = new Catalog();

foreach($products as $product) {
    $catalog->addToCatalog($product);
}
echo "<pre>";
print_r($catalog->renderCatalog());