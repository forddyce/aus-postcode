<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/bigtable/admin/v2/bigtable_table_admin.proto

namespace Google\Cloud\Bigtable\Admin\V2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * An initial split point for a newly created table.
 *
 * Generated from protobuf message <code>google.bigtable.admin.v2.CreateTableRequest.Split</code>
 */
class CreateTableRequest_Split extends \Google\Protobuf\Internal\Message
{
    /**
     * Row key to use as an initial tablet boundary.
     *
     * Generated from protobuf field <code>bytes key = 1;</code>
     */
    private $key = '';

    public function __construct() {
        \GPBMetadata\Google\Bigtable\Admin\V2\BigtableTableAdmin::initOnce();
        parent::__construct();
    }

    /**
     * Row key to use as an initial tablet boundary.
     *
     * Generated from protobuf field <code>bytes key = 1;</code>
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Row key to use as an initial tablet boundary.
     *
     * Generated from protobuf field <code>bytes key = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setKey($var)
    {
        GPBUtil::checkString($var, False);
        $this->key = $var;

        return $this;
    }

}

