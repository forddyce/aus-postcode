<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/bigtable/admin/v2/table.proto

namespace Google\Cloud\Bigtable\Admin\V2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A GcRule which deletes cells matching all of the given rules.
 *
 * Generated from protobuf message <code>google.bigtable.admin.v2.GcRule.Intersection</code>
 */
class GcRule_Intersection extends \Google\Protobuf\Internal\Message
{
    /**
     * Only delete cells which would be deleted by every element of `rules`.
     *
     * Generated from protobuf field <code>repeated .google.bigtable.admin.v2.GcRule rules = 1;</code>
     */
    private $rules;

    public function __construct() {
        \GPBMetadata\Google\Bigtable\Admin\V2\Table::initOnce();
        parent::__construct();
    }

    /**
     * Only delete cells which would be deleted by every element of `rules`.
     *
     * Generated from protobuf field <code>repeated .google.bigtable.admin.v2.GcRule rules = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Only delete cells which would be deleted by every element of `rules`.
     *
     * Generated from protobuf field <code>repeated .google.bigtable.admin.v2.GcRule rules = 1;</code>
     * @param \Google\Cloud\Bigtable\Admin\V2\GcRule[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setRules($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\Bigtable\Admin\V2\GcRule::class);
        $this->rules = $arr;

        return $this;
    }

}

