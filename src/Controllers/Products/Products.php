<?php

namespace Controllers\Products;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Products\Products as ProductsDao;

class Products extends PublicController
{
    private $viewData = [
        "products"      => [],
        "fltName"       => "",
        "fltStatus"     => "",
        "fltStatus_act" => "",
        "fltStatus_ina" => "",
        "ordBy"         => "productName",
        "ordDesc"       => false,
        "page"          => 0,
        "itemsPerPage"  => 10,

        "ordNameUrl"    => "",
        "ordPriceUrl"   => ""
    ];

    public function run(): void
    {

        $this->viewData["fltName"]   = trim(strval($_GET["fltName"] ?? ""));
        $this->viewData["fltStatus"] = trim(strval($_GET["fltStatus"] ?? ""));
        $ordByReq                    = $_GET["ordBy"] ?? "productName";
        $this->viewData["ordBy"]     = in_array($ordByReq, ["productName", "productPrice"]) ? $ordByReq : "productName";
        $this->viewData["ordDesc"]   = (isset($_GET["ordDesc"]) && $_GET["ordDesc"] === "1");
        $this->viewData["page"]      = max(0, intval($_GET["page"] ?? 0));
        $this->viewData["itemsPerPage"] = max(1, intval($_GET["items"] ?? 10));


        $this->viewData["fltStatus_act"] = ($this->viewData["fltStatus"] === "ACT") ? "selected" : "";
        $this->viewData["fltStatus_ina"] = ($this->viewData["fltStatus"] === "INA") ? "selected" : "";


        $base = "index.php?page=Products_Products"
            . "&fltName=" . urlencode($this->viewData["fltName"])
            . "&fltStatus=" . urlencode($this->viewData["fltStatus"]);


        $nameDesc = ($this->viewData["ordBy"] === "productName" && !$this->viewData["ordDesc"]) ? "&ordDesc=1" : "";
        $this->viewData["ordNameUrl"] = $base . "&ordBy=productName" . $nameDesc;


        $priceDesc = ($this->viewData["ordBy"] === "productPrice" && !$this->viewData["ordDesc"]) ? "&ordDesc=1" : "";
        $this->viewData["ordPriceUrl"] = $base . "&ordBy=productPrice" . $priceDesc;


        $this->viewData["products"] = ProductsDao::getProducts(
            $this->viewData["fltName"],
            $this->viewData["fltStatus"],
            $this->viewData["ordBy"],
            $this->viewData["ordDesc"],
            $this->viewData["page"],
            $this->viewData["itemsPerPage"]
        );


        Renderer::render("products/products", $this->viewData);
    }
}
