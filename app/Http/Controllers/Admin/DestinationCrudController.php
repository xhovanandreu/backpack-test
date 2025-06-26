<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DestinationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DestinationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DestinationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Destination::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/destination');
        CRUD::setEntityNameStrings('destination', 'destinations');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->setupColumns();

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(DestinationRequest::class);
        $this->setupFields();

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }


    protected function setupFields(): void
    {
        CRUD::addFields([
            [  // Select
                'label'     => "Article",
                'type'      => 'select',
                'name'      => 'article_id', // the db column for the foreign key

                // optional
                // 'entity' should point to the method that defines the relationship in your Model
                // defining entity will make Backpack guess 'model' and 'attribute'
                'entity'    => 'article',

                // optional - manually specify the related model and attribute
                'model'     => "App\Models\Article", // related model
                'attribute' => 'title', // foreign key attribute that is shown to user
            ],
            [
                'name'      => 'name',
                'label'     => "Destination name",
                'type'      => 'text',
            ],
            [
                'name'      => 'description',
                'label'     => "Destination description",
                'type'      => 'textarea',
            ],
            [
                'name'      => 'active',
                'label'     => "Active",
                'type'  => 'switch',
                'default' => true,
                'color'    => '#232323',
                'onLabel' => '✓',
                'offLabel' => '✕',
            ]
        ]);
    }

    protected function setupColumns(): void
    {
        CRUD::addColumns([
            [  // Select
                'label'     => "Article",
                'type'      => 'select',
                'name'      => 'article_id', // the db column for the foreign key

                // optional
                // 'entity' should point to the method that defines the relationship in your Model
                // defining entity will make Backpack guess 'model' and 'attribute'
                'entity'    => 'article',

                // optional - manually specify the related model and attribute
                'model'     => "App\Models\Article", // related model
                'attribute' => 'title', // foreign key attribute that is shown to user

            ],


            [
                'name'      => 'name',
                'label'     => "Destination name",
                'type'      => 'text',
            ],
            [
                'name'      => 'active',
                'label'     => "Active",
                'type'  => 'switch'
            ],


        ]);
    }
}
