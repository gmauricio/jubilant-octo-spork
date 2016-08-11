<?php
namespace Vacancy\Model;
 
/**
* A test vacancy model
*/
class Vacancy
{
    /**
     * The id of the vacancy
     *
     * @var integer
     */
    public $id;
  
    /**
     * The vacancy title
     *
     * @var string
     */
    public $title;

    /**
     * The vacancy content/description
     *
     * @var string
     */
    public $content;

    /**
     * The vacancy description
     *
     * @var string
     */
    public $description;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($id) {
        $this->id = $id;

        return $this;
    }

    public function getContent() {
        return $this->id;
    }

    public function setContent($id) {
        $this->id = $id;

        return $this;
    }

    public function getDescription() {
        return $this->id;
    }

    public function setDescription($id) {
        $this->id = $id;

        return $this;
    }
}