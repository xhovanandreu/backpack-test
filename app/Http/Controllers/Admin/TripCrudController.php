<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TripRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TripCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TripCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Trip::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/trip');
        CRUD::setEntityNameStrings('trip', 'trips');
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

    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(TripRequest::class);
        $this->setupFields();


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
                'label'     => "Start Point",
                'type'      => 'select',
                'name'      => 'start_point', // the db column for the foreign key

                // optional
                // 'entity' should point to the method that defines the relationship in your Model
                // defining entity will make Backpack guess 'model' and 'attribute'
                'entity'    => 'startStop',

                // optional - manually specify the related model and attribute
                'model'     => "App\Models\Stop", // related model
                'attribute' => 'name', // foreign key attribute that is shown to user

            ],

            [  // Select
                'label'     => "End Point",
                'type'      => 'select',
                'name'      => 'end_point', // the db column for the foreign key

                // optional
                // 'entity' should point to the method that defines the relationship in your Model
                // defining entity will make Backpack guess 'model' and 'attribute'
                'entity'    => 'endStop',

                // optional - manually specify the related model and attribute
                'model'     => "App\Models\Stop", // related model
                'attribute' => 'name', // foreign key attribute that is shown to user

            ],

            [
                'name'      => 'starting_time',
                'label'     => "Starting time",
                'type'      => 'datetime',
            ],


        ]);
    }

    protected function setupColumns(): void
    {
        CRUD::addColumns([
            [
                'label'     => 'Start Point', // Table column heading
                'type'      => 'select',
                'name'      => 'start_point', // the column that contains the ID of that connected entity;
                'entity'    => 'startStop', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => "App\Models\Stop", // foreign key model
            ],
            [
                'label'     => 'End Point', // Table column heading
                'type'      => 'select',
                'name'      => 'end_point', // the column that contains the ID of that connected entity;
                'entity'    => 'endStop', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => "App\Models\Stop", // foreign key model
            ],
            [   'name'  => 'starting_time', // The db column name
                'label' => 'Starting time', // Table column heading
                'type'  => 'datetime',
                'format' => 'H:m l Y',
            ],
            [
               'name'  => 'estimated_arrival_time', // The db column name
               'label' => 'Estimated arrival time',
               'type'  => 'datetime',
               'format' => 'H:m l Y',
            ],
        ]);
    }


    /**
     * Store a newly created resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {



        $this->crud->hasAccessOrFail('create');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        // register any Model Events defined on fields
        $this->crud->registerFieldEvents();

        // insert item in the db
        $item = $this->crud->create($this->crud->getStrippedSaveRequest($request));
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();
dd('vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv df');
        return $this->crud->performSaveAction($item->getKey());
    }
}
