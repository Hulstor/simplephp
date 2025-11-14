<?php

namespace Controllers\Products;

use Controllers\PublicController;
use Utilities\Context;
use Utilities\Paging;
use Dao\Products\Products as DaoProducts;
use Views\Renderer;

class Products extends PublicController
{
    private string $partialName = "";
    private string $status = "";
    private string $orderBy = "";
    private bool $orderDescending = false;
    private int $pageNumber = 1;
    private int $itemsPerPage = 10;

    private array $viewData = [];
    private array $products = [];
    private int $productsCount = 0;
    private int $pages = 0;

    public function run(): void
    {
        $this->getParamsFromContext();
        $this->getParams();

        $result = DaoProducts::getProducts(
            $this->partialName,
            $this->status,
            $this->orderBy,
            $this->orderDescending,
            $this->pageNumber - 1,
            $this->itemsPerPage
        );

        $this->products      = $result["products"];
        $this->productsCount = $result["total"];
        $this->pages         = $this->productsCount > 0
            ? (int)ceil($this->productsCount / $this->itemsPerPage)
            : 1;

        if ($this->pageNumber > $this->pages) {
            $this->pageNumber = $this->pages;
        }

        $this->setParamsToContext();
        $this->setParamsToDataView();

        Renderer::render("products/products", $this->viewData);
    }

    private function getParams(): void
    {
        // Filtro por nombre
        if (isset($_GET["partialName"])) {
            $this->partialName = trim($_GET["partialName"]);
        }

        // Filtro por estado
        if (isset($_GET["status"]) && in_array($_GET["status"], ["ACT", "INA", "EMP"], true)) {
            $this->status = $_GET["status"];
        }
        if ($this->status === "EMP") {
            $this->status = "";
        }

        // Ordenamiento
        if (isset($_GET["orderBy"]) && in_array($_GET["orderBy"], ["productId", "productName", "productPrice", "clear"], true)) {
            $this->orderBy = $_GET["orderBy"];
        }
        if ($this->orderBy === "clear") {
            $this->orderBy = "";
        }

        // Dirección del orden
        if (isset($_GET["orderDescending"])) {
            $this->orderDescending = boolval($_GET["orderDescending"]);
        }

        // Página y items por página
        if (isset($_GET["pageNum"])) {
            $this->pageNumber = max(1, intval($_GET["pageNum"]));
        }
        if (isset($_GET["itemsPerPage"])) {
            $this->itemsPerPage = max(1, intval($_GET["itemsPerPage"]));
        }
    }

    private function getParamsFromContext(): void
    {
        $this->partialName     = Context::getContextByKey("products_partialName") ?? "";
        $this->status          = Context::getContextByKey("products_status") ?? "";
        $this->orderBy         = Context::getContextByKey("products_orderBy") ?? "";
        $this->orderDescending = boolval(Context::getContextByKey("products_orderDescending") ?? false);
        $this->pageNumber      = intval(Context::getContextByKey("products_page") ?? 1);
        $this->itemsPerPage    = intval(Context::getContextByKey("products_itemsPerPage") ?? 10);

        if ($this->pageNumber < 1) {
            $this->pageNumber = 1;
        }
        if ($this->itemsPerPage < 1) {
            $this->itemsPerPage = 10;
        }
    }

    private function setParamsToContext(): void
    {
        Context::setContext("products_partialName", $this->partialName, true);
        Context::setContext("products_status", $this->status, true);
        Context::setContext("products_orderBy", $this->orderBy, true);
        Context::setContext("products_orderDescending", $this->orderDescending, true);
        Context::setContext("products_page", $this->pageNumber, true);
        Context::setContext("products_itemsPerPage", $this->itemsPerPage, true);
    }

    private function setParamsToDataView(): void
    {
        $this->viewData["partialName"]     = $this->partialName;
        $this->viewData["status"]          = $this->status;
        $this->viewData["orderBy"]         = $this->orderBy;
        $this->viewData["orderDescending"] = $this->orderDescending;
        $this->viewData["pageNum"]         = $this->pageNumber;
        $this->viewData["itemsPerPage"]    = $this->itemsPerPage;
        $this->viewData["productsCount"]   = $this->productsCount;
        $this->viewData["pages"]           = $this->pages;
        $this->viewData["products"]        = $this->products;

        // Flags para ordenar columnas (usados por las meta etiquetas {{if}})
        if ($this->orderBy !== "") {
            $orderByKeyNoOrder = "OrderBy" . ucfirst($this->orderBy);
            $this->viewData[$orderByKeyNoOrder] = true;

            $orderKey = "Order" . ucfirst($this->orderBy);
            if ($this->orderDescending) {
                $orderKey .= "Desc";
            }
            $this->viewData[$orderKey] = true;
        }

        // Estado seleccionado en el combo
        $statusKey = "status_" . ($this->status === "" ? "EMP" : $this->status);
        $this->viewData[$statusKey] = "selected";

        // Paginación
        $this->viewData["pagination"] = Paging::getPagination(
            $this->productsCount,
            $this->itemsPerPage,
            $this->pageNumber,
            "index.php?page=Products_Products",
            "Products_Products"
        );
    }
}
