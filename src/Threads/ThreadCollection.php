<?php
/**
 * Created by PhpStorm.
 * User: exile
 * Date: 27/05/17
 * Time: 11:34 PM
 */

namespace PHPChan\Threads;


use ArrayAccess;
use Countable;
use PHPChan\Boards\Board;
use SeekableIterator;
use Serializable;

class ThreadCollection implements ArrayAccess, SeekableIterator, Countable, Serializable
{
    private $collection;
    private $position;


    public function fromStdClass(\stdClass $data, Board $parentBoard)
    {
        foreach ($data->threads as $thread) {
            $temp = new Thread($thread);
            $temp->setParent($parentBoard);
            $this->collection[] = $temp;
        }
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->collection[] = $value;
        } else {
            $this->collection[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->collection[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->collection[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->collection[$offset]) ? $this->collection[$offset] : null;
    }

    /* Method required for SeekableIterator interface */

    public function seek($position)
    {
        if (!isset($this->collection[$position])) {
            throw new OutOfBoundsException("invalid seek position ($position)");
        }

        $this->position = $position;
    }

    /* Methods required for Iterator interface */

    public function rewind()
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->collection[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function valid()
    {
        return isset($this->collection[$this->position]);
    }

    public function count()
    {
        return (int)count($this->collection);
    }

    public function serialize()
    {
        return serialize($this->collection);
    }

    public function unserialize($data)
    {
        $this->collection = unserialize($data);
    }

    public function getData()
    {
        return $this->collection;
    }
}