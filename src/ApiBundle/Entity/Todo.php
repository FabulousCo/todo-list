<?php

namespace ApiBundle\Entity;

use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinTable;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Todo
 *
 * @ORM\Table(name="todo")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\TodoRepository")
 * @UniqueEntity("title")
 */
class Todo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     * @Assert\NotNull()
     * @Assert\Type(
     *     type="string",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", columnDefinition="ENUM('open','done')")
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified", type="datetime", nullable=true)
     */
    private $modified;

    /**
     * Many Todos have Many Categories.
     * @ManyToMany(targetEntity="Category", inversedBy="todos")
     * @JoinTable(name="todos_categories")
     */
    private $categories;

    /**
     * Todo constructor.
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->created = Carbon::now();
        $this->status = 'open';
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Todo
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Todo
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     *
     * @return Todo
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @param Category $category
     *
     * @return Todo;
     */
    public function addCategory(Category $category)
    {
        if ($this->categories->contains($category)) return $this;

        $this->categories[] = $category;

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getCategories()
    {
        return $this->categories;
    }
}

