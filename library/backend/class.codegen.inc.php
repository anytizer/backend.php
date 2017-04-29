<?php
namespace backend;

/**
 * PHP based incremental code generator.
 */
class codegen
    extends \common\mysql
{
    private $context;
    private $name;
    private $current; # Current record in the database

    /**
     * @todo Fix this class
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function setup($context = "", $name = "")
    {
        $this->context = strtoupper(preg_replace('/[^a-z]/is', "", $context));
        $this->name = strtoupper(preg_replace('/[^a-z]/is', "", $name));
        if ($this->context == "" || $this->name == "") {
            \common\stopper::message('We need a valid context/name for codegen');
        }
    }

    public function generate_code($params = array())
    {
        $code = "";

        $sql = "
SELECT
	*
FROM query_code_generators
WHERE
	code_context='{$this->context}'
	AND code_name='{$this->name}'

	# Optionally use the YEAR flag
	# AND code_year=YEAR(CURRENT_DATE())
	AND IF(is_year='Y', code_year=YEAR(CURRENT_DATE()), TRUE)
LIMIT 1;";
        if ($this->current = $this->row($sql)) {
            # We normally expect this here.
        } else {
            # Insert the codegen entity with default values.
            \common\stopper::message("Code not found with for this criteria. {$this->context}:{$this->name}");
        }

        $context = strtolower($this->context . '_' . $this->name);
        if (method_exists($this, $context)) {
            $code = $this->$context($params);
        } else {
            #\common\stopper::message('No code handler: '.$this->context);
            $code = $this->default_handler($params);
        }
        $this->update();

        return $code;
    }

    /**
     * If there are no default handlers to process/generate the codes, this will work.
     */
    protected function default_handler($params = array())
    {
        $runner = str_pad($this->current['code_value'], $this->current['code_length'], $this->current['code_mask'], STR_PAD_LEFT);
        $code = "{$this->current['code_prefix']}{$runner}{$this->current['code_suffix']}";

        return $code;
    }

    /**
     * Update the code reading, for next record
     */
    protected function update()
    {
        $update_sql = "
UPDATE query_code_generators SET
	code_value = IF(code_value<(POW(10, {$this->current['code_length']})-1), code_value + 1, 0)
WHERE
	code_context='{$this->context}'
	AND code_name='{$this->name}'
	# AND code_year=YEAR(CURRENT_DATE())
;";
        return $this->query($update_sql);
    }

    public function __destruct()
    {
    }

    protected function colman_student($params = array())
    {
        $params['gender'] = isset($params['gender']) ? substr(trim($params['gender']), 0, 1) : 'U';
        $params['percent'] = isset($params['percent']) ? (float)preg_replace('/[^0-9\.]/', "", $params['percent']) : '0.00';
        # ST2010070015M

        $academic_grade_sql = "
SELECT
	rank_value `grade`
FROM academic_grades
WHERE
	{$params['percent']} BETWEEN  rank_from AND rank_to
;";
        $grades = $this->row($academic_grade_sql);
        if (!isset($grades['grade'])) {
            $grades = array(
                'grade' => 0
            );
        }

        $runner = str_pad($this->current['code_value'], $this->current['code_length'], $this->current['code_mask'], STR_PAD_LEFT);
        $code = "{$this->current['code_prefix']}{$this->current['code_year']}{$runner}{$grades['grade']}{$params['gender']}";

        return $code;
    }
}

