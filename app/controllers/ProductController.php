<?php

use PhalconRest\Constants\ErrorCodes as ErrorCodes;
use PhalconRest\Exceptions\UserException;

/**
 * @resource("Product")
 */
class ProductController extends \App\Mvc\Controller
{
    /**
     * @title("All")
     * @description("Get all products")
     * @response("Collection of Product objects or Error object")
     * @requestExample("GET /products")
     * @responseExample({
     *     "product": {
     *         "id": 144,
     *         "title": "Title",
     *         "brand": "Brand name",
     *         "color": "green",
     *         "createdAt": "1427646703000",
     *         "updatedAt": "1427646703000"
     *     }
     * })
     */
    public function all()
    {
        $products = Product::find();

        return $this->respondCollection($products, new ProductTransformer(), 'products');
    }

    /**
     * @title("Find")
     * @description("Get all products")
     * @response("Product object or Error object")
     * @requestExample("GET /product/14")
     * @responseExample({
     *     "product": {
     *         "title": "Title",
     *         "brand": "Brand name",
     *         "color": "green",
     *         "createdAt": "1427646703000",
     *         "updatedAt": "1427646703000"
     *     }
     * })
     */
    public function find($product_id)
    {
        $product = Product::findFirst((int)$product_id);

        if (!$product) {
            throw new UserException(ErrorCodes::DATA_NOTFOUND, 'Product with id: #' . (int)$product_id . ' could not be found.');
        }

        return $this->respondItem($product, new ProductTransformer, 'product');
    }

    /**
     * @title("Create")
     * @description("Create a new product")
     * @response("Product object or Error object")
     * @requestExample({
     *      "title": "Title",
     *      "brand": "Brand name",
     *      "color": "green",
     *      "createdAt": "1427646703000",
     *      "updatedAt": "1427646703000"
     * })
     * @responseExample({
     *     "product": {
     *         "id": 144,
     *         "title": "Title",
     *         "brand": "Brand name",
     *         "color": "green",
     *         "createdAt": "1427646703000",
     *         "updatedAt": "1427646703000"
     *     }
     * })
     */
    public function create()
    {
        $data = $this->request->getJsonRawBody();

        $product = new Product;
        $product->assign((array)$data);

        if (!$product->save()) {
            throw new UserException(ErrorCodes::DATA_FAIL, 'Could not create product.');
        }

        return $this->respondItem($product, new ProductTransformer, 'product');
    }

    /**
     * @title("Update")
     * @description("Update a product")
     * @response("Product object or Error object")
     * @requestExample({
     *     "title": "Updated Title"
     * })
     * @responseExample({
     *     "product": {
     *         "id": 144,
     *         "title": "Updated Title",
     *         "brand": "Brand name",
     *         "color": "green",
     *         "createdAt": "1427646703000",
     *         "updatedAt": "1427646703000"
     *     }
     * })
     */
    public function update($product_id)
    {
        $product = Product::findFirst((int)$product_id);

        if (!$product) {
            throw new UserException(ErrorCodes::DATA_NOTFOUND, 'Could not find product.');
        }

        $data = $this->request->getJsonRawBody();
        $product->assign((array)$data);

        if (!$product->save()) {
            throw new UserException(ErrorCodes::DATA_FAIL, 'Could not update product.');
        }

        return $this->respondItem($product, new ProductTransformer, 'product');
    }

    /**
     * @title("Remove")
     * @description("Remove a product")
     * @response("Result object or Error object")
     * @responseExample({
     *     "result": "OK"
     * })
     */
    public function delete($product_id)
    {
        $product = Product::findFirst((int)$product_id);

        if (!$product) {
            throw new UserException(ErrorCodes::DATA_NOTFOUND, 'Could not find product.');
        }

        if (!$product->delete()) {
            throw new UserException(ErrorCodes::DATA_FAIL, 'Could not remove product.');
        }

        return $this->respondOK();
    }
}