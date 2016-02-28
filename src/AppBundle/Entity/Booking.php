<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as AppAssert;

/**
 * Booking
 *
 * @ORM\Table(name="booking")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BookingRepository")
 * @AppAssert\UniqueInPeriod
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
     * @Assert\NotBlank()
     * @Assert\Length(min = 3)
     */
    private $fname;

    /**
     * @var string
     *
     * @ORM\Column(name="lname", type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = 3)
     */
    private $lname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     *
     * @Assert\NotBlank()
     */
    private $phone;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fromDate", type="datetime")
     *
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    private $fromDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="toDate", type="datetime")
     *
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    private $toDate;

    /**
     * @var string
     *
     * @ORM\Column(name="room", type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\Choice(
     *  choices = { "red", "green", "blue" }
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
     * @var bool
     *
     * @ORM\Column(name="reviewed", type="boolean")
     */
    private $reviewed;

    /**
     * Booking constructor.
     */
    public function __construct()
    {
        $this->created = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->validated = false;
        $this->reviewed = false;
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
        $date = clone $fromDate;
        $date->setTime(12, 0, 0);

        $this->fromDate = $date;

        return $this;
    }

    /**
     * Get fromDate
     *
     * @return \DateTime
     */
    public function getFromDate()
    {
        $date = null;

        if ($this->fromDate instanceof \DateTime) {
            $date = $this->fromDate;
            $date->setTime(12, 0, 0);
        }

        return $date;
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
        $date = clone $toDate;
        $date->setTime(11, 59, 59);

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
        $date = null;

        if ($this->toDate instanceof \DateTime) {
            $date = $this->toDate;
            $date->setTime(11, 59, 59);
        }

        return $date;
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
     * Get the translatable room string.
     *
     * @return string
     */
    public function getRoomTranslatable()
    {
        return 'booking.room.' . $this->room;
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

    /**
     * Set reviewed
     * When an admin reviews the booking.
     *
     * @param boolean $reviewed
     *
     * @return Booking
     */
    public function setReviewed($reviewed)
    {
        $this->reviewed = $reviewed;

        return $this;
    }

    /**
     * Get reviewed
     * When an admin reviews the booking.
     *
     * @return bool
     */
    public function getReviewed()
    {
        return $this->reviewed;
    }

    /**
     * Return the number of nights
     * for this booking.
     *
     * @return int
     */
    public function countNights()
    {
        $nights = 0;

        $period = new \DatePeriod($this->fromDate, \DateInterval::createFromDateString('1 day'), $this->toDate);
        foreach ($period as $day) {
            $nights++;
        }

        return $nights;
    }
}