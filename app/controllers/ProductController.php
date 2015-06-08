<?php

use PhalconRest\Exceptions\UserException,
    Library\PhalconRest\Constants\ErrorCodes as ErrorCodes;

/**
 * @resource("Product")
 */
class ProductController extends PhalconRest\Mvc\Controller
{

    /**
     * @title('All')
     * @description('Get all products')
     * @response("Collection of Product objects or Error object")
     * @requestExample("GET /products")
     * @responseExample({
     *     "product": {
     *         "id": 144,
     *         "title": "Title",
     *         "brand": "Brand name",
     *         "color": "green",
     *         "createdAt": 1427646703000,
     *         "updatedAt": 1427646703000,
     *     }
     * })
     */
    public function all()
    {
        $products = Products::all();

        return $this->createCollection($products, new ProductTransformer, 'products');
    }

    /**
     * @title('Find')
     * @description('Get all products')
     * @response("Product object or Error object")
     * @requestExample("GET /product/14")
     * @responseExample({
     *     "product": {
     *         "title": "Title",
     *         "brand": "Brand name",
     *         "color": "green",
     *         "createdAt": 1427646703000,
     *         "updatedAt": 1427646703000
     *     }
     * })
     */
    public function find($product_id)
    {

        $product = Products::findFirstById($product_id);

        if (!$product){

            throw new UserException(ErrorCodes::DATA_NOTFOUND, 'Project with id: #' . $product_id . ' could not be found.');
        }

        return $this->createItem($product, new ProductTransformer, 'product');
    }

    /**
     * @title('Create')
     * @description('Create a new product')
     * @response("Product object or Error object")
     * @requestExample({
     *      "title": "Title",
     *      "brand": "Brand name",
     *      "color": "green",
     *      "createdAt": 1427646703000,
     *      "updatedAt": 1427646703000
     * })
     * @responseExample({
     *     "result": "OK",
     *     "product": {
     *         "id": 144,
     *         "title": "Title",
     *         "brand": "Brand name",
     *         "color": "green",
     *         "createdAt": 1427646703000,
     *         "updatedAt": 1427646703000
     *     }
     * })
     */
    public function create()
    {
        $data = $this->request->getJsonRawBody();

        $product = new Products;

        // Prepare method is provided by \OA\Phalcon\Mvc\Model
        $product->prepare($data);

        if (!$product->save()){

            throw new UserException(ErrorCodes::DATA_FAIL, 'Could not create product.');
        }

        return $this->createItemWithOK($product, new ProductTransformer, 'product');
    }

    /**
     * @title('Update')
     * @description('Update a product')
     * @response("Product object or Error object")
     * @requestExample({
     *     "product": {
     *         "title": "Updated Title",
     *     }
     * })
     * @responseExample({
     *     "result": "OK",
     *     "product": {
     *         "id": 144,
     *         "title": "Updated Title",
     *         "brand": "Brand name",
     *         "color": "green",
     *         "createdAt": 1427646703000,
     *         "updatedAt": 1427646703000
     *     }
     * })
     */
    public function update($product_id)
    {
        $product = Products::findFirstById($product_id);

        if (!$product){

            throw new UserException(ErrorCodes::DATA_NOTFOUND, 'Could not find product.');
        }


        $data = $this->request->getJsonRawBody();

        // Prepare method is provided by \OA\Phalcon\Mvc\Model
        $product->prepare($data);

        if (!$product->save()){

            throw new UserException(ErrorCodes::DATA_FAIL, 'Could not update product.');
        }

        return $this->createItemWithOK($product, new ProductTransformer, 'product');
    }

    /**
     * @title('Remove')
     * @description('Remove a product')
     * @response("Result object or Error object")
     * @responseExample({
     *     "result": "OK"
     * })
     */
    public function remove($product_id)
    {

        if (!Products::remove($product_id)){

            throw new UserException(ErrorCodes::DATA_FAIL, 'Could not remove product.');
        }

        return $this->respondWithOK();
    }
}
