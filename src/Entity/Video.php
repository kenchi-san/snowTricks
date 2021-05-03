<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use App\Validator\IsVideoAuthorizedLink;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=VideoRepository::class)
 */
class Video
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @IsVideoAuthorizedLink()
     */
    private $link;

    /**
     * @ORM\ManyToOne(targetEntity=Figure::class, inversedBy="videos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $figure;


    const FROM_SOCIAL = [
        '#https://www.youtube.com/watch\?v=(?P<code>[^&]*)#',
        '#https://youtu.be/(?P<code>[^?]*)#'
    ];
    const GOOD_SOCIAL = 'https://www.youtube.com/embed/';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getFigure(): ?Figure
    {
        return $this->figure;
    }

    public function setFigure(?Figure $figure): self
    {
        $this->figure = $figure;

        return $this;
    }

    /**
     * @return $this
     */
    public function cleanAndSetLink($link)
    {

        if (preg_match("~(?:https:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._:/?#[\]@!\$&'\(\)\*\+,;=.]+~", $link, $matches)) {
            $link = $matches[0];
            foreach (self::FROM_SOCIAL as $regex){
                if (preg_match($regex, $link, $matches)) {
                    $link = self::GOOD_SOCIAL. $matches['code'];
                    $this->setLink($link);
                }
            }
        }
        return $this->setLink($link);
    }


}
