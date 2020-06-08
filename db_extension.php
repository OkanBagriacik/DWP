<?php
// establishes a connection to application database
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

// creates a new user and add to database
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

// logs in the registered user upon correct user info entered in the form
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
// get the current user information
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
// updates the user data in the database
function updateUser($firstname, $lastname, $username, $email, $password, $address)
{
    $conn = connectDb();

    $sql = "UPDATE Users SET FirstName='{$firstname}', LastName='{$lastname}', UserName='{$username}', Email='{$email}', Password='{$password}', Address='{$address}' WHERE UserID='{$_SESSION["userid"]}'";

    if ($conn->query($sql) === TRUE) {
        return true;
    }
}

// add a  new product to the database
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

// gets the product with the specified product id
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

// update a product with the new entered product data
function updateProduct($productId, $productname, $price, $description, $imageurl)
{
    $conn = connectDb();

    $sql = "UPDATE Products SET ProductName='{$productname}', Price='{$price}', Description='{$description}', ImageURL='{$imageurl}' WHERE ProductID='{$productId}'";

    if ($conn->query($sql) === TRUE) {
        return true;
    }

    return false;
}

// gets all the products from the database
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

// deletes the product with the specified product id
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
//get a product category with the spedified id from the database
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

// adds a neew product category to the database
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

// deletes a product category from the database
function deleteCategory($categoryId)
{
    $conn = connectDb();

    $sql = "DELETE FROM Categories WHERE CategoryID={$categoryId}";

    if ($conn->query($sql) === TRUE) {
        return true;
    }

    return false;
}

// retrieves all the product categories from the database
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

// change a specified product category info
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
// get all products in the cart
function getCartProducts()
{
    $sessionId = session_id();

    $conn = connectDb();

    $sql = "SELECT * FROM Cart INNER JOIN CartProducts ON Cart.CartID = CartProducts.CartID INNER JOIN Products ON CartProducts.ProductID = Products.ProductID WHERE SessionID='{$sessionId}' AND ConfirmedStatus = false";
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

// get cart data (sessionId, cartId, totalCost)
function getCart()
{
    $sessionId = session_id();
    $conn = connectDb();


    $sql = "SELECT * FROM Cart WHERE SessionID='{$sessionId}' AND ConfirmedStatus = false";
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

// add a new product to the cart, and save the data to the database
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

// change a product quantity in the database
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

// remove an added product from the cart 
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

// decrement a cart producti for instance if a there are 4 apple in the cart, make it 3
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

//create a new cart for the logged in user
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

//confim order and updated the cart status (this  function changes a column in the databaase, it updates "ConfirmedStatus" column to true to indicate that a cart is confirmed)
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
