<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Booking
 *
 * @ORM\Table(name="booking")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BookingRepository")
 */
class Booking
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
     * @ORM\Column(name="fname", type="string", length=255)
     *
     * @Assert\NotBlank(message = "booking.fname.not_blank")
     * @Assert\Length(min = 3)
     */
    private $fname;

    /**
     * @var string
     *
     * @ORM\Column(name="lname", type="string", length=255)
     *
     * @Assert\NotBlank(message = "booking.lname.not_blank")
     * @Assert\Length(min = 3)
     */
    private $lname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     *
     * @Assert\NotBlank(message = "booking.email.not_blank")
     * @Assert\Email(message = "booking.email.invalid")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     *
     * @Assert\NotBlank(message = "booking.phone.not_blank")
     */
    private $phone;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fromDate", type="date")
     *
     * @Assert\NotBlank(message = "booking.fromDate.not_blank")
     * @Assert\Date(message = "booking.fromDate.invalid")
     */
    private $fromDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="toDate", type="date")
     *
     * @Assert\NotBlank(message = "booking.toDate.not_blank")
     * @Assert\Date(message = "booking.toDate.invalid")
     */
    private $toDate;

    /**
     * @var string
     *
     * @ORM\Column(name="room", type="string", length=255)
     *
     * @Assert\NotBlank(message = "booking.room.not_blank")
     * @Assert\Choice(
     *  choices = { "red", "green", "blue" },
     *  message = "booking.room.invalid"
     * )
     */
    private $room;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var bool
     *
     * @ORM\Column(name="validated", type="boolean")
     */
    private $validated;

    /**
     * Booking constructor.
     */
    public function __construct()
    {
        $this->created = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->validated = false;
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
     * Set fname
     *
     * @param string $fname
     *
     * @return Booking
     */
    public function setFname($fname)
    {
        $this->fname = $fname;

        return $this;
    }

    /**
     * Get fname
     *
     * @return string
     */
    public function getFname()
    {
        return $this->fname;
    }

    /**
     * Set lname
     *
     * @param string $lname
     *
     * @return Booking
     */
    public function setLname($lname)
    {
        $this->lname = $lname;

        return $this;
    }

    /**
     * Get lname
     *
     * @return string
     */
    public function getLname()
    {
        return $this->lname;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Booking
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Booking
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set fromDate
     *
     * @param \DateTime $fromDate
     *
     * @return Booking
     */
    public function setFromDate(\DateTime $fromDate)
    {
        $this->fromDate = $fromDate;

        return $this;
    }

    /**
     * Get fromDate
     *
     * @return \DateTime
     */
    public function getFromDate()
    {
        return $this->fromDate;
    }

    /**
     * Set toDate
     *
     * @param \DateTime $toDate
     *
     * @return Booking
     */
    public function setToDate(\DateTime $toDate)
    {
        $this->toDate = $toDate;

        return $this;
    }

    /**
     * Get toDate
     *
     * @return \DateTime
     */
    public function getToDate()
    {
        return $this->toDate;
    }

    /**
     * Set room
     *
     * @param string $room
     *
     * @return Booking
     */
    public function setRoom($room)
    {
        $this->room = $room;

        return $this;
    }

    /**
     * Get room
     *
     * @return string
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Booking
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;

        return $this;
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
     * Set validated
     *
     * @param boolean $validated
     *
     * @return Booking
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;

        return $this;
    }

    /**
     * Get validated
     *
     * @return bool
     */
    public function getValidated()
    {
        return $this->validated;
    }
}