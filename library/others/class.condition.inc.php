<?php
namespace others;

/**
 * Data Type for AND/OR conditions: SQL Helper only
 *
 * @package Interfaces
 */
class condition
    extends \abstracts\datatype
{
    # We can overload these properties
    private $AND;
    private $OR;

    # Accept blank declarations and conditions?
    private $accept_blank = true;

    /**
     * Set the two conditions as array.
     */
    public function __construct()
    {
        parent::__construct(array(
            'AND',
            'OR',
        ));

        $this->AND = array();
        $this->OR = array();
    }

    /**
     * Sets conditions
     */
    public function add($where = 'AND', $associative_condition = array())
    {
        switch ($where) {
            case 'OR':
            case 'or':
            case '||':
            case '|':
                foreach ($associative_condition as $key => $condition) {
                    $this->OR[$key] = $condition;
                }
                break;
            case 'FULL':
            case 'COMPLETE':
                # Writes complete conditions
                # TODO: Avoid escaping these conditions while compiling.
                foreach ($associative_condition as $key => $condition) {
                    $this->AND[] = $condition;
                }
                break;
            case 'AND':
            case 'and':
            case '&&':
            case '&':
                foreach ($associative_condition as $key => $condition) {
                    $this->AND[$key] = $condition;
                }
                break;
            default:
                break;
        }
    }

    /**
     * Read the condition. Later on, these conditions will be used by the CRUD methods.
     *
     * @return Array of conditions
     */
    public function get_condition($where = 'AND')
    {
        $conditions = $this->AND;
        switch ($where) {
            case 'OR':
            case 'or':
            case '||':
            case '|':
                $conditions = $this->OR;
                break;
            /*
            case 'AND':
            case 'and':
            case '&&':
            case '&':
            default:
                break;
            */
        }

        return $conditions;
    }

    /**
     * Reset accept blank - flag
     */
    public function accept_blank($accept = false)
    {
        $this->accept_blank = ($accept === true);
    }
}
