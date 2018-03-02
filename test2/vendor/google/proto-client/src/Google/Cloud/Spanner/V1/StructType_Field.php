<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/spanner/v1/type.proto

namespace Google\Cloud\Spanner\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Message representing a single field of a struct.
 *
 * Generated from protobuf message <code>google.spanner.v1.StructType.Field</code>
 */
class StructType_Field extends \Google\Protobuf\Internal\Message
{
    /**
     * The name of the field. For reads, this is the column name. For
     * SQL queries, it is the column alias (e.g., `"Word"` in the
     * query `"SELECT 'hello' AS Word"`), or the column name (e.g.,
     * `"ColName"` in the query `"SELECT ColName FROM Table"`). Some
     * columns might have an empty name (e.g., !"SELECT
     * UPPER(ColName)"`). Note that a query result can contain
     * multiple fields with the same name.
     *
     * Generated from protobuf field <code>string name = 1;</code>
     */
    private $name = '';
    /**
     * The type of the field.
     *
     * Generated from protobuf field <code>.google.spanner.v1.Type type = 2;</code>
     */
    private $type = null;

    public function __construct() {
        \GPBMetadata\Google\Spanner\V1\Type::initOnce();
        parent::__construct();
    }

    /**
     * The name of the field. For reads, this is the column name. For
     * SQL queries, it is the column alias (e.g., `"Word"` in the
     * query `"SELECT 'hello' AS Word"`), or the column name (e.g.,
     * `"ColName"` in the query `"SELECT ColName FROM Table"`). Some
     * columns might have an empty name (e.g., !"SELECT
     * UPPER(ColName)"`). Note that a query result can contain
     * multiple fields with the same name.
     *
     * Generated from protobuf field <code>string name = 1;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * The name of the field. For reads, this is the column name. For
     * SQL queries, it is the column alias (e.g., `"Word"` in the
     * query `"SELECT 'hello' AS Word"`), or the column name (e.g.,
     * `"ColName"` in the query `"SELECT ColName FROM Table"`). Some
     * columns might have an empty name (e.g., !"SELECT
     * UPPER(ColName)"`). Note that a query result can contain
     * multiple fields with the same name.
     *
     * Generated from protobuf field <code>string name = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

    /**
     * The type of the field.
     *
     * Generated from protobuf field <code>.google.spanner.v1.Type type = 2;</code>
     * @return \Google\Cloud\Spanner\V1\Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * The type of the field.
     *
     * Generated from protobuf field <code>.google.spanner.v1.Type type = 2;</code>
     * @param \Google\Cloud\Spanner\V1\Type $var
     * @return $this
     */
    public function setType($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Spanner\V1\Type::class);
        $this->type = $var;

        return $this;
    }

}

