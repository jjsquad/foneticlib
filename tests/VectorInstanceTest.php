<?php
use Fonetic\Vector\Vector;

/**
 * Created by PhpStorm.
 * User: squad
 * Date: 05/08/16
 * Time: 02:06
 */
class VectorInstanceTest extends PHPUnit_Framework_TestCase
{
    public function test_instance()
    {
        $this->assertInstanceOf(Vector::class, new Vector());
    }

    public function test_return_as_array()
    {
        $vec = new Vector("teste teste");
        $this->assertEquals(['teste', 'teste'], $vec->toArray());
    }

    public function test_return_combined()
    {
        $vec = new Vector("teste teste");
        $this->assertEquals("teste teste", $vec->combine());
    }

    public function test_return_element_as_magic_string()
    {
        $vec = new Vector("teste teste");
        $this->assertEquals("teste", $vec->elementAt(0));
    }

    public function test_convert_element_to_string()
    {
        $numeros = new Vector();
        $numeros->addElement(1);
        $this->assertEquals(1, $numeros->elementAt(0)->toString());
    }

    public function test_get_element_at_index()
    {
        $vec = new Vector("hello world");
        $this->assertEquals("hello", $vec->elementAt(0));
        $this->assertEquals("world", $vec->elementAt(1));
    }

    public function test_compareTo_success_and_fail()
    {
        $vec = new Vector("hello world");
        //success result == 0
        $result = $vec->elementAt(0)->compareTo('hello');
        $this->assertEquals(0, $result);
        
        //fails result <> 0
        $result = $vec->elementAt(0)->compareTo('world');
        $this->assertEquals($result != 0, $result);
    }

    public function test_add_different_types_of_elements_and_count()
    {
        $vec = new Vector();
        $vec->addElement(['hello world']);
        $this->assertEquals(['hello world'], $vec->toArray());
        //check count of elements
        $this->assertEquals(1, $vec->count());
        
        $vec->addElement('one_word');
        $this->assertEquals(['hello world', 'one_word'], $vec->toArray());
        //check count
        $this->assertEquals(2, $vec->count());
        
        $vec->addElement(12345);
        $this->assertEquals(['hello world', 'one_word', 12345], $vec->toArray());
        //check count
        $this->assertEquals(3, $vec->count());
    }
    
    public function test_set_element_of_different_types()
    {
        $vec = new Vector("hello world");
        //set element 1 'world' as array
        $vec->setElementAt(1, ['hello', 'world']);
        $this->assertEquals(['hello',  ['hello', 'world']], $vec->toArray());
        //set element 0 as float
        $vec->setElementAt(0, 345.99);
        $this->assertEquals([345.99,  ['hello', 'world']], $vec->toArray());
    }

    public function test_if_has_some_element()
    {
        $vec = new Vector("hello world vector");
        //check for a single element
        $this->assertEquals(true, $vec->has("world"));
        $vec->setElementAt(2, ['vector', 'array!']);
        //check for a array element
        $this->assertEquals(true, $vec->has(['vector', 'array!']));
    }

    public function test_if_not_has_some_element()
    {
        $vec = new Vector("hello world");
        //check if not HAS element
        $this->assertEquals(false, $vec->has("yey!"));
        //check if not HAS an array element;
        $this->assertEquals(false, $vec->has(['hello', 'world']));
    }

    public function test_remove_element_at()
    {
        $vec = new Vector("hello dummy world!");
        $this->assertEquals("hello world!", $vec->removeElementAt(1)->combine());
        $this->assertEquals(2, $vec->count());
    }

    public function test_remove_elements()
    {
        $vec = new Vector("remove hello world this yey! items");
        $this->assertEquals("hello world yey!", $vec->removeElements(['remove', 'this', 'items'])->combine());
    }
}