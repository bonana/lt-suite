<?php

/**
 * Class to handle Customers for CRUD.
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @author      Alexander Karlsson <alexander@livetime.nu>
 * @package     Customer
 * @subpackage  Customer/Classes
 */

namespace Livetime\Customer;

use \Livetime\Models\Customer;
use \Livetime\Models\CustomerContact;
use \Livetime\Models\Project;
use \Livetime\Models\ProjectProduct;

use Livetime\Includes\Util as Util;

class Customer_Manager extends Base_Manager
{
    /**
     * The current customer we are working on.
     *
     * @since       1.0.0
     * @var         Models\Customer     $current_customer       The current customer
     */
    protected $current_customer;

    /**
     * The current project we are working on.
     *
     * @since       1.0.0
     * @var         Models\Project      $current_project        The current project
     */
    protected $current_project;

    /**
     * Initialize our class.
     *
     * @since       1.0.0
     */
    public function __construct()
    {
        $this->plugin_dir = LTS_CUSTOMER;
    }

    /**
     * Check if a customer already exists
     *
     * @since       1.0.0
     * @param       string      $org_nr             The organisation number to check against
     * @return      bool                            Returns true if the customer exists, false otherwise.
     */
    public function exists( $org_nr )
    {
        $org_nr = Util::stf( str_replace( '-', '', $org_nr ) );
        $customer = Customer::where( 'org_nr', '=', $org_nr )->first();

        if ( $customer !== null ) {
            $this->current_customer = $customer;
            return true;
        }

        return false;
    }

    /**
     * Create a new customer and set the basic data for it.
     *
     * @since       1.0.0
     * @param       string      $company_name       The name of the company.
     * @param       string      $org_nr             Org.nr. of the company.
     * @param       string      $county             The companys county.
     * @param       string      $town               The companys town.
     * @param       string      $address            The company address.
     * @param       string      $post_code          The company post code.
     * @return      self                            Returns self for method chaining.
     */
    public function create( $company_name, $org_nr, $county, $town, $address, $post_code )
    {
        try {
            $this->current_customer = new Customer();

            $this->current_customer->name           = Util::stf( $company_name );
            $this->current_customer->org_nr         = Util::stf( str_replace( '-', '', $org_nr ) );
            $this->current_customer->county         = Util::stf( $county );
            $this->current_customer->town           = Util::stf( $town );
            $this->current_customer->address        = Util::stf( $address );
            $this->current_customer->postal         = Util::stf( $post_code );
            $this->current_customer->save();

            return $this;
        } catch ( Illuminate\Database\QueryException $e ) {
            $error_code = $e->error_info[1];

            if ( $error_code == 1062 )
                return null;
        }
    }

    /**
     * Add a contact person to the ceurrent customer.
     *
     * @since       1.0.0
     * @param       string      $name       The name of the person.
     * @param       string      $surname    The surname of the person.
     * @param       string      $email      The email of the person.
     * @param       string      $phone      The phone of the person.
     */
    public function add_contact( $name, $surname, $email, $phone )
    {
        if ( $this->current_customer !== null ) {
            try {
                $customer_contact = new CustomerContact();

                $customer_contact->name     = Util::stf( $name );
                $customer_contact->surname  = Util::stf( $surname );
                $customer_contact->email    = Util::stf( $email );
                $customer_contact->phone    = Util::stf( $phone );

                $this->current_customer->contacts()->save( $customer_contact );
            } catch ( Illuminate\Database\QueryException $e ) {
                $error_code = $e->error_info[1];

                if ( $error_code == 1062 )
                    return null;
            }
        }
    }

    /**
     * Add meta information to a customer.
     *
     * @since       1.0.0
     * @param       string      $key                The key to add
     * @param       string      $value              Value to be added to $key
     * @return      null/self                       Returns other self for method chaining or null if we don't have a customer.
     */
    public function add_meta( $key, $value )
    {
        if ( $this->current_customer !== null ) {
            $meta = new CustomerMeta();

            $meta->key   = Util::stf( $key );
            $meta->value = Util::stf( $value );

            $this->current_customer->meta()->save( $meta );

            return $this;
        }

        return null;
    }

    /**
     * Get the current customer.
     *
     * @since       1.0.0
     * @return      Models\Customer                 Current customer
     */
    public function get_customer()
    {
        return $this->current_customer;
    }

    /**
     * Get current project.
     *
     * @since       1.0.0
     * @return      Models\Project                  The current project
     */
    public function get_project()
    {
        return $this->current_project;
    }

    /**
     * Adds a new project to the current customer.
     *
     * @since       1.0.0
     * @param       int         $handler_id         ID of the staff member adding the project.
     * @param       int         $theme_id           ID of the chosen theme for the project.
     * @return      self                            Returns self for method chaining
     */
    public function add_project( $handler_id, $theme_id = NULL )
    {
        if ( !$this->current_customer ) return null;

        $this->current_project = new Project();

        $this->current_project->handler_id = Util::stf( $handler_id );
        $this->current_project->theme_id   = Util::stf( $theme_id );
        $this->current_project->status_id = 1;
        $this->current_project->hash = md5( $this->current_customer->id . time() );

        $this->current_customer->projects()->save( $this->current_project );

        return $this;
    }

    /**
     * Adds a product to a project.
     *
     * @since       1.0.0
     * @param       int         $project_id         The ID of the project to add to
     * @param       string      $name               The name of the product.
     * @param       string      $description        Product description.
     * @param       decimal     $price              Product price.
     * @param       int         $qty                Product quantity
     * @return      self                            Returns self for method chaining.
     */
    public function add_product( $project_id, $name, $description, $price, $qty )
    {
        $product = new ProjectProduct();

        $product->project_id  = Util::stf( $project_id );
        $product->name        = Util::stf( $name );
        $product->description = $description;
        $product->price       = Util::stf( $price );
        $product->qty         = Util::stf( $qty );

        $product->save();

        return $this;
    }

    /**
     * Helper function for add_product.
     *
     * @since       1.0.0
     * @param       string      $name               The name of the product.
     * @param       string      $description        Product description.
     * @param       decimal     $price              Product price.
     * @param       int         $qty                Product quantity
     * @return      self                            Returns self for method chaining
     */
    public function add_project_product( $name, $description, $price, $qty )
    {
        if ( !$this->current_project ) return null;

        $this->add_product( $this->current_project->id, $name, $description, $price, $qty );

        return $this;
    }
}