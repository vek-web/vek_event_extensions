<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "vek_event_extensions" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Vek\EventExtensions\Domain\Model;

use DERHANSEN\SfEventMgt\Domain\Model\Registration as OriginalRegistration;

class Registration extends OriginalRegistration
{
    /**
     * Class Registration
     *
     * Extended registration model that adds fields for certificates, reminders
     * and other metadata used by vek_event_extensions.
     */

    protected ?int $certificate = 0;
    protected ?int $kammer = 0;
    protected string $efnnummer = '';
    protected bool $reminded = false;
    protected bool $linksent = false;
    protected bool $certificatecompliance = true;
    protected bool $certificatesent = false;

    /**
     * @return int|null
     */
    public function getCertificate(): ?int
    {
        return $this->certificate;
    }

    /**
     * @param int|null $certificate
     */
    public function setCertificate(?int $certificate): void
    {
        $this->certificate = $certificate;
    }

    /**
     * @return int|null
     */
    public function getKammer(): ?int
    {
        return $this->kammer;
    }

    /**
     * @param int|null $kammer
     */
    public function setKammer(?int $kammer): void
    {
        $this->kammer = $kammer;
    }

    /**
     * @return string
     */
    public function getEfnnummer(): string
    {
        return $this->efnnummer;
    }

    /**
     * @param string $efnnummer
     */
    public function setEfnnummer(string $efnnummer): void
    {
        $this->efnnummer = $efnnummer;
    }

    /**
     * @param bool $reminded
     */
    public function setReminded(bool $reminded): void
    {
        $this->reminded = $reminded;
    }

    /**
     * @return bool
     */
    public function getReminded(): bool
    {
        return $this->reminded;
    }

    /**
     * @param bool $linksent
     */
    public function setLinksent(bool $linksent): void
    {
        $this->linksent = $linksent;
    }

    /**
     * @return bool
     */
    public function getLinksent(): bool
    {
        return $this->linksent;
    }

    /**
     * @return bool
     */
    public function getCertificatecompliance(): bool
    {
        return $this->certificatecompliance;
    }

    /**
     * @param bool $certificatecompliance
     */
    public function setCertificatecompliance(bool $certificatecompliance): void
    {
        $this->certificatecompliance = $certificatecompliance;
    }

    /**
     * @return bool
     */
    public function getCertificatesent(): bool
    {
        return $this->certificatesent;
    }

    /**
     * @param bool $certificatesent
     */
    public function setCertificatesent(bool $certificatesent): void
    {
        $this->certificatesent = $certificatesent;
    }
}
