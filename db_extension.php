<?php
function connectDb()
{
    $servername = "localhost";
    $username = "root";
    $password = "admin";
    $dbname = "homework";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        header("error.php");
    }

    return $conn;
}

function createUser($firstname, $lastname, $userName, $email, $UserPassword, $address, $usertype)
{
    if (empty($usertype)) $usertype = "Customer";

    $conn = connectDb();

    $sql = "INSERT INTO Users (FirstName, LastName, UserName, Email, Password, Address, UserType)
    VALUES ('{$firstname}', '{$lastname}', '{$userName}','{$email}', '{$UserPassword}', '{$address}', '{$usertype}')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

function login($username, $password)
{
    $conn = connectDb();

    $sql = "SELECT * FROM Users WHERE UserName='{$username}' AND Password='{$password}'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return null;
};

function getUser()
{
    $conn = connectDb();

    $sql = "SELECT * FROM Users WHERE UserID='{$_SESSION["userid"]}' ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return null;
}

function updateUser($firstname, $lastname, $username, $email, $password, $address)
{
    $conn = connectDb();

    $sql = "UPDATE Users SET FirstName='{$firstname}', LastName='{$lastname}', UserName='{$username}', Email='{$email}', Password='{$password}', Address='{$address}' WHERE UserID='{$_SESSION["userid"]}'";

    if ($conn->query($sql) === TRUE) {
        return true;
    }
}


function addProduct($productname, $productCategoryId, $price, $description, $imageurl)
{
    $conn = connectDb();

    $sql = "INSERT INTO products (ProductName, CategoryID, Price, Description, ImageURL)
    VALUES ('{$productname}','{$productCategoryId}', '{$price}', '{$description}','{$imageurl}')";

    if ($conn->query($sql) === TRUE) {
        //"New product created successfully";
        return true;
    }
    echo "Error: " . $sql . "<br>" . $conn->error;
    return false;

    $conn->close();
}

function getProduct($productId)
{
    $conn = connectDb();

    $sql = "SELECT * FROM Products WHERE ProductId='{$productId}'";
    $result = $conn->query($sql);

    try {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        } else return null;
    } catch (Exception $ex) {
        return null;
    }
}

function updateProduct($productId, $productname, $price, $description, $imageurl)
{
    $conn = connectDb();

    $sql = "UPDATE Products SET ProductName='{$productname}', Price='{$price}', Description='{$description}', ImageURL='{$imageurl}' WHERE ProductID='{$productId}'";

    if ($conn->query($sql) === TRUE) {
        return true;
    }

    return false;
}


function getAllProducts()
{
    $conn = connectDb();

    $sql = "SELECT * FROM Products INNER JOIN Categories ON Products.CategoryID = Categories.CategoryID";
    $result = $conn->query($sql);

    try {
        if ($result->num_rows > 0) {
            $products = array();
            while ($row = $result->fetch_assoc()) {
                array_push($products, $row);
            }

            return $products;
        } else return array();
    } catch (Exception $ex) {
        return array();
    }
}

function deleteProduct($productId)
{
    $conn = connectDb();
    $sql = "DELETE FROM Products WHERE ProductID={$productId}";

    if ($conn->query($sql) === TRUE) {
        return true;
    }

    return false;
}

// product category operations 

function getProductCategoryById($categoryId)
{
    $conn = connectDb();

    $sql = "SELECT * FROM Categories WHERE CategoryId='{$categoryId}'";
    $result = $conn->query($sql);

    try {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        } else return null;
    } catch (Exception $ex) {
        return null;
    }
}

function addCategory($categoryName)
{
    $conn = connectDb();

    $sql = "INSERT INTO Categories (CategoryName)
    VALUES ('{$categoryName}')";

    if ($conn->query($sql) === TRUE) {
        //"New product created successfully";
        return true;
    }
    echo "Error: " . $sql . "<br>" . $conn->error;
    return false;

    $conn->close();
}

function deleteCategory($categoryId)
{
    $conn = connectDb();

    $sql = "DELETE FROM Categories WHERE CategoryID={$categoryId}";

    if ($conn->query($sql) === TRUE) {
        return true;
    }

    return false;
}

function listCategories()
{
    $conn = connectDb();

    $sql = "SELECT * FROM Categories";
    $result = $conn->query($sql);

    try {
        if ($result->num_rows > 0) {
            $products = array();
            while ($row = $result->fetch_assoc()) {
                array_push($products, $row);
            }

            return $products;
        } else return array();
    } catch (Exception $ex) {
        return array();
    }
}

function editProductCategory($categoryId, $categoryName)
{
    $conn = connectDb();

    $sql = "UPDATE Categories SET CategoryName='{$categoryName}' WHERE CategoryID='{$categoryId}'";

    if ($conn->query($sql) === TRUE) {
        return true;
    }

    return false;
}

// cart operations
function getCartProducts()
{
    $sessionId = session_id();

    $conn = connectDb();

    $sql = "SELECT * FROM Cart INNER JOIN CartProducts ON Cart.CartID = CartProducts.CartID INNER JOIN Products ON CartProducts.ProductID = Products.ProductID WHERE SessionID='{$sessionId}' ";
    $result = $conn->query($sql);

    try {
        if ($result->num_rows > 0) {
            $cartProducts = array();
            while ($row = $result->fetch_assoc()) {
                array_push($cartProducts, $row);
            }

            return $cartProducts;
        } else return null;
    } catch (Exception $ex) {
        return null;
    }
}

function getCart()
{
    $sessionId = session_id();
    $conn = connectDb();


    $sql = "SELECT * FROM Cart WHERE SessionID='{$sessionId}'";
    $result = $conn->query($sql);

    try {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            return $row;
        } else return null;
    } catch (Exception $ex) {
        return null;
    }
}

function addToCart($productId)
{
    $cart = getCart();

    if ($cart == null) {
        createCart();
        $cart = getCart();
    }

    $cartProducts = getCartProducts();

    $product = null;

    if (count($cartProducts) > 0) {
        foreach ($cartProducts as $cartProduct) {
            if ($productId == $cartProduct['ProductID']) {
                $product = $cartProduct;
                break;
            }
        }
    }


    if ($product) {
        $currentQuantity = $product['ProductQuantity'];
        updateCart($productId,  $currentQuantity + 1);
    } else {
        $conn = connectDb();
        $cartId = $cart['CartID'];

        $sql = "INSERT INTO CartProducts (CartID, ProductID, ProductQuantity) VALUES ('{$cartId}','{$productId}', 1)";

        if ($conn->query($sql) === TRUE) {
            //"New product created successfully";
            return true;
        }
        echo "Error: " . $sql . "<br>" . $conn->error;
        return false;

        $conn->close();
    }
}

function updateCart($productId, $updatedQuantity)
{
    $cart = getCart();
    $conn = connectDb();

    $sql = "UPDATE CartProducts SET ProductQuantity='{$updatedQuantity}' WHERE CartID='{$cart['CartID']}' AND ProductID = {$productId}";

    if ($conn->query($sql) === TRUE) {
        return true;
    }

    return false;
}

function deleteProductFromCart($productId)
{
    $cart = getCart();
    $cartID = $cart['CartID'];
    $conn = connectDb();

    $sql = "DELETE FROM CartProducts WHERE CartID={$cartID} AND ProductID={$productId}";

    if ($conn->query($sql) === TRUE) {
        return true;
    }

    return false;
}

function deleteFromCart($productId)
{
    $cartProducts = getCartProducts();
    $product = null;

    foreach ($cartProducts as $cartProduct) {
        if ($productId == $cartProduct['ProductID']) {
            $product = $cartProduct;
            break;
        }
    }

    if ($product) {
        $currentQuantity = $product['ProductQuantity'];
        updateCart($productId,  $currentQuantity - 1);
    }
}

function createCart()
{
    $conn = connectDb();
    $totalCost = 0;
    $sessionId = session_id();
    $sql = "INSERT INTO Cart (SessionID, TotalCost)
    VALUES ('{$sessionId}', '{$totalCost}')";

    if ($conn->query($sql) === TRUE) {
        //"New product created successfully";
        return true;
    }
    echo "Error: " . $sql . "<br>" . $conn->error;
    return false;

    $conn->close();
}

//confim order
function confirmOrder()
{
    $cart = getCart();
    $conn = connectDb();
    $sessionId = session_id();
    $confirmedOrder = true;

    $sql = "UPDATE Cart SET ConfirmedStatus={$confirmedOrder} WHERE SessionID='{$sessionId}' ";

    if ($conn->query($sql) === TRUE) {
        return true;
    }

    return false;
}
