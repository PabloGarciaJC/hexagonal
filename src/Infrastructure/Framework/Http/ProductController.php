<?php

namespace Infrastructure\Framework\Http;

use Application\UseCase\ListProducts;
use Application\UseCase\ShowProduct;
use Application\UseCase\CreateProduct;
use Infrastructure\Framework\Helper\FlashMessage;

class ProductController
{
    private ListProducts $listProducts;
    private ShowProduct $showProduct;
    private CreateProduct $createProduct;

    public function __construct(
        ListProducts $listProducts,
        ShowProduct $showProduct,
        CreateProduct $createProduct
    ) {
        $this->listProducts = $listProducts;
        $this->showProduct = $showProduct;
        $this->createProduct = $createProduct;
    }

    public function index(): void
    {
        // List all active products
        $products = $this->listProducts->execute(true);
        include __DIR__ . '/../View/products_catalog.php';
    }

    public function show(): void
    {
        $productId = (int)($_GET['id'] ?? 0);
        $product = $this->showProduct->execute($productId);

        if (!$product) {
            header('Location: /?shop=catalog');
            exit;
        }

        include __DIR__ . '/../View/product_detail.php';
    }

    public function create(): void
    {
        // Admin: show form
        include __DIR__ . '/../View/product_form.php';
    }

    public function store(): void
    {
        // Admin: process form
        $sku = trim($_POST['sku'] ?? '');
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = (float)($_POST['price'] ?? 0);
        $stock = (int)($_POST['stock'] ?? 0);
        $active = isset($_POST['active']) ? 1 : 0;

        // Validaciones
        $error = null;
        if (empty($sku)) {
            $error = 'El SKU es requerido';
        } elseif (empty($name)) {
            $error = 'El nombre del producto es requerido';
        } elseif (empty($description)) {
            $error = 'La descripción es requerida';
        } elseif ($price <= 0) {
            $error = 'El precio debe ser mayor a 0';
        } elseif ($stock < 0) {
            $error = 'El stock no puede ser negativo';
        }

        if ($error) {
            FlashMessage::setError($error);
            header('Location: /?shop=create');
            exit;
        }

        try {
            $product = $this->createProduct->execute($sku, $name, $description, $price, 'USD', $stock, (bool)$active);
            FlashMessage::setSuccess("Producto '{$product->getName()}' creado exitosamente");
            header('Location: /?shop=catalog');
            exit;
        } catch (\Exception $e) {
            FlashMessage::setError('Error: ' . $e->getMessage());
            header('Location: /?shop=create');
            exit;
        }
    }
}
