<?php
declare(strict_types=1);

namespace LmdmNext\Domain\Oidc\Client;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table("oidc_clients")]
class Client
{
    #[ORM\Column(type: 'string', length: 32, unique: true, nullable: false)]
    private string $_clientId;
    #[ORM\Column(type: 'string', length: 256, nullable: false)]
    private string $_clientSecret;
    /**
     * @var string[]
     */
    #[ORM\Column(type: 'simple array')]
    private array $_redirect_url;
}