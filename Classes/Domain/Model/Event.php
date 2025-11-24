<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "vek_event_extensions" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Vek\EventExtensions\Domain\Model;

use DERHANSEN\SfEventMgt\Domain\Model\Event as OriginalEvent;
use DateTime;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;

class Event extends OriginalEvent
{
    /**
     * Class Event
     *
     * Extended event model that adds additional fields used by the vek_event_extensions
     * extension (meeting info, reminders, certificate data, etc.).
     */

    protected int $eventtype = 0;
    protected string $meetingLink = '';
    protected string $meetingId = '';
    protected string $meetingAdditionalId = '';
    protected bool $reminder = true;
    protected int $reminderPeriod = 8;
    protected string $reminderMail = '';
    protected string $reminderMailName = '';
    protected string $vnr = '';
    protected string $certificateHost = '';
    protected string $certificateSupervisor = '';
    protected string $certificateText = '';
    protected string $certificateEventLocation = '';
    protected string $certificateLocation = '';
    protected ?DateTime $certificateDate = null;
    protected int $fbPunkte = 0;

    /**
     * @Cascade("remove")
     */
    protected ?FileReference $certificateimage = null;

    /**
     * @return int
     */
    public function getEventtype(): int
    {
        return $this->eventtype;
    }

    /**
     * @param int $eventtype
     */
    public function setEventtype(int $eventtype): void
    {
        $this->eventtype = $eventtype;
    }

    /**
     * @return string
     */
    public function getMeetingLink(): string
    {
        return $this->meetingLink;
    }

    /**
     * @param string $meetingLink
     */
    public function setMeetingLink(string $meetingLink): void
    {
        $this->meetingLink = $meetingLink;
    }

    /**
     * @return string
     */
    public function getMeetingid(): string
    {
        return $this->meetingId;
    }

    /**
     * @param string $meetingId
     */
    public function setMeetingId(string $meetingId): void
    {
        $this->meetingId = $meetingId;
    }

    /**
     * @return string
     */
    public function getMeetingAdditionalId(): string
    {
        return $this->meetingAdditionalId;
    }

    /**
     * @param string $meetingAdditionalId
     */
    public function setMeetingAdditionalId(string $meetingAdditionalId): void
    {
        $this->meetingAdditionalId = $meetingAdditionalId;
    }

    /**
     * @param bool $reminder
     */
    public function setReminder(bool $reminder): void
    {
        $this->reminder = $reminder;
    }

    /**
     * @return bool
     */
    public function getReminder(): bool
    {
        return $this->reminder;
    }

    /**
     * @return int
     */
    public function getReminderPeriod(): int
    {
        return $this->reminderPeriod;
    }

    /**
     * @param int $reminderPeriod
     */
    public function setReminderPeriod(int $reminderPeriod): void
    {
        $this->reminderPeriod = $reminderPeriod;
    }

    /**
     * @return string
     */
    public function getReminderMail(): string
    {
        return $this->reminderMail;
    }

    /**
     * @param string $reminderMail
     */
    public function setReminderMail(string $reminderMail): void
    {
        $this->reminderMail = $reminderMail;
    }

    /**
     * @return string
     */
    public function getReminderMailName(): string
    {
        return $this->reminderMailName;
    }

    /**
     * @param string $reminderMailName
     */
    public function setReminderMailName(string $reminderMailName): void
    {
        $this->reminderMailName = $reminderMailName;
    }

    /**
     * @return string
     */
    public function getVnr(): string
    {
        return $this->vnr;
    }

    /**
     * @param string $vnr
     */
    public function setVnr(string $vnr): void
    {
        $this->vnr = $vnr;
    }

    /**
     * @return string
     */
    public function getCertificateHost(): string
    {
        return $this->certificateHost;
    }

    /**
     * @param string $certificateHost
     */
    public function setCertificateHost(string $certificateHost): void
    {
        $this->certificateHost = $certificateHost;
    }

    /**
     * @return string
     */
    public function getCertificateSupervisor(): string
    {
        return $this->certificateSupervisor;
    }

    /**
     * @param string $certificateSupervisor
     */
    public function setCertificateSupervisor(string $certificateSupervisor): void
    {
        $this->certificateSupervisor = $certificateSupervisor;
    }

    /**
     * @return string
     */
    public function getCertificateText(): string
    {
        return $this->certificateText;
    }

    /**
     * @param string $certificateText
     */
    public function setCertificateText(string $certificateText): void
    {
        $this->certificateText = $certificateText;
    }

    /**
     * @return string
     */
    public function getCertificateEventLocation(): string
    {
        return $this->certificateEventLocation;
    }

    /**
     * @param string $certificateEventLocation
     */
    public function setCertificateEventLocation(string $certificateEventLocation): void
    {
        $this->certificateEventLocation = $certificateEventLocation;
    }

    /**
     * @return string
     */
    public function getCertificateLocation(): string
    {
        return $this->certificateLocation;
    }

    /**
     * @param string $certificateLocation
     */
    public function setCertificateLocation(string $certificateLocation): void
    {
        $this->certificateLocation = $certificateLocation;
    }

    /**
     * @return DateTime|null
     */
    public function getCertificateDate(): ?DateTime
    {
        return $this->certificateDate;
    }

    /**
     * @param DateTime|null $certificateDate
     */
    public function setCertificateDate(?DateTime $certificateDate): void
    {
        $this->certificateDate = $certificateDate;
    }

    /**
     * @return int
     */
    public function getFbPunkte(): int
    {
        return $this->fbPunkte;
    }

    /**
     * @param int $fbPunkte
     */
    public function setFbPunkte(int $fbPunkte): void
    {
        $this->fbPunkte = $fbPunkte;
    }

    /**
     * @return FileReference|null
     */
    public function getCertificateimage(): ?FileReference
    {
        return $this->certificateimage;
    }

    /**
     * @param FileReference|null $certificateimage
     */
    public function setCertificateimage(?FileReference $certificateimage): void
    {
        $this->certificateimage = $certificateimage;
    }
}
