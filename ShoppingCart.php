<?php
require_once("CartItem.php");

// Start a session before handling any html.
session_name('ShoppingCart');
session_start();

$products = array(
    array("name" => "Coke", "price" => 8.99),
    array("name" => "Pepsi", "price" => 1.60),
    array("name" => "Fanta", "price" => 7.89),
    array("name" => "Sprite", "price" => 1.9),
    array("name" => "Dr Pepper", "price" => 18.65)
);

function printProducts($array)
{
    foreach ($array as $product)
    {
        $price = sprintf('%.2f', $product["price"]);
        echo "Name: " . $product["name"] . ", Price: $" . $price;
        echo "<form method='post' action='ShoppingCart.php'>";
        echo "<input type='hidden' name='name' value='" . $product["name"] ."'>";
        echo "<input type='hidden' name='price' value='" . $price ."'>";
        echo "<input type='submit' name='add' value='Add to Cart' />";
        echo "</form>";
    }
}

function printShoppingList($array)
{
    foreach ($array as $item)
    {
        echo $item->display();
        echo "<form method='post' action='ShoppingCart.php'>";
        echo "<input type='hidden' name='name' value='" . $item->getName() ."'>";
        echo "<input type='submit' name='remove' value='Remove from Cart' />";
        echo "</form>";
    }
}

function printOverallTotal($array)
{
    $overallTotal = 0;

    foreach ($array as $item)
    {
        $overallTotal += $item->calculateCost();
    }

    echo "$" . sprintf('%.2f', $overallTotal);
}

function findItem($array, $itemName)
{
    foreach ($array as $item)
    {
        if ($item->getName() == $itemName)
        {
            $item->updateQuantity();
            return true;
        }
    }
    return false;
}

if (isset($_SESSION["shoppingList"]))
{
    $shoppingList = $_SESSION["shoppingList"];
}
else
{
    $shoppingList = [];
}

if (isset($_POST["add"]))
{
    $item = new CartItem($_POST["name"], $_POST["price"]);

    if (!findItem($shoppingList, $_POST["name"]))
    {
        $shoppingList[] = $item;
    }
}

if (isset($_POST["remove"]))
{
    foreach ($shoppingList as $elementKey => $item)
    {
        if ($item->getName() == $_POST["name"])
        {
            unset($shoppingList[$elementKey]);
            break;
        }
    }
}

echo "<h2>Products:</h2>";
printProducts($products);

echo "<br><h2>My Cart:</h2>";
printShoppingList($shoppingList);

echo "<h3>Overall Total:</h3>";
printOverallTotal($shoppingList);

$_SESSION['shoppingList'] = $shoppingList;
session_write_close();