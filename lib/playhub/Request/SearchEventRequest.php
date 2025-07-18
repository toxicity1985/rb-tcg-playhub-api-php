<?php

namespace Playhub\Request;

use Playhub\Contract\SearchRequestInterface;
use Symfony\Component\Validator\Constraints as Assert;
use DateTimeImmutable;

class SearchEventRequest implements SearchRequestInterface
{
    #[Assert\Date]
    public ?DateTimeImmutable $startDateAfter = null;

    #[Assert\Type('string')]
    public ?string $name = null;

    #[Assert\Type('float')]
    public ?string $latitude = null;

    #[Assert\Type('float')]
    public ?string $longitude = null;


    #[Assert\Choice([5, 25, 50, 100, 250])]
    public ?string $numMiles = null;

    public function getUrlParameters(): string
    {
        $urlParameters = '';
        if ($this->name !== null) {
            $urlParameters .= '&name=' . $this->name;
        }
        if ($this->startDateAfter !== null) {
            $urlParameters .= '&start_date_after=' . $this->startDateAfter->format('Y-m-d\TH:i:s.000\Z');
        }
        if ($this->latitude !== null) {
            $urlParameters .= '&latitude=' . $this->latitude;
        }
        if ($this->longitude !== null) {
            $urlParameters .= '&longitude=' . $this->longitude;
        }
        if ($this->numMiles !== null) {
            $urlParameters .= '&num_miles=' . $this->numMiles;
        }

        return $urlParameters;
    }
}
