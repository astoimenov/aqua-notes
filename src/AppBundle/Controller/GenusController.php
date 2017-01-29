<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Genus;
use AppBundle\Entity\GenusNote;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class GenusController extends Controller
{
    /**
     * Entity manager
     * @var [type]
     */
    protected $manager;

    /**
     * Doctrine entity repository
     * @var [type]
     */
    protected $repository;

    /**
     * @Route("/genus", name="genus_index")
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($value='')
    {
        $genuses = $this->getRepository(Genus::class)->findAllPublished();

        return $this->render('AppBundle:Genus:index.html.twig', [
            'genuses' => $genuses,
        ]);
    }

    /**
     * @Route("/genus/new", name="genus_store")
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function storeAction()
    {
        $genus = new Genus();
        $genus->setName('Octopuse'.rand(1, 100));
        $genus->setSubFamily('Octopodinae'.rand(1, 100));
        $genus->setSpeciesCount(rand(100, 99999));

        $note = new GenusNote();
        $note->setUsername('AquaWeaver');
        $note->setUserAvatarFilename('ryan.jpeg');
        $note->setNote('I counted 8 legs... as they wrapped around me');
        $note->setCreatedAt(new \DateTime('-1 month'));

        $note->setGenus($genus);

        $manager = $this->getManager();

        $manager->persist($genus);
        $manager->persist($note);
        $manager->flush();

        return new Response('<html><body>Genus created!</body></html>');
    }

    /**
     * @Route("/genus/{name}", name="genus_show")
     * @Method("GET")
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Genus $genus)
    {
        // $cache = $this->get('doctrine_cache.providers.my_markdown_cache');
        // $key = md5($funFact);
        // if ($cache->contains($key)) {
        //     $funFact = $cache->fetch($key);
        // } else {
        //     $funFact = $this->get('markdown.parser')->transform($funFact);
        //     $cache->save($key, $funFact);
        // }

        $recentNotes = $this->getRepository(GenusNote::class)->findAllRecentNotesForGenus($genus);

        return $this->render('AppBundle:Genus:show.html.twig', [
            'genus' => $genus,
            'recentNotesCount' => count($recentNotes),
        ]);
    }

    /**
     * @Route("/genus/{name}/notes", name="genus_show_notes")
     * @Method("GET")
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function getNotesAction(Genus $genus)
    {
        foreach ($genus->getNotes() as $note) {
            $notes[] = [
                'id' => $note->getId(),
                'username' => $note->getUsername(),
                'avatarUri' => '/images/'.$note->getUserAvatarFilename(),
                'note' => $note->getNote(),
                'date' => $note->getCreatedAt()->format('M d, Y'),
            ];
        }

        $data = [
            'notes' => $notes,
        ];

        return new JsonResponse($data);
    }

    public function getManager()
    {
        if (!$this->manager) {
            $this->manager = $this->get('doctrine')->getManager();
        }

        return $this->manager;
    }

    public function getRepository($modelClass)
    {
        if (!$this->repository) {
            $this->repository = $this->getManager()->getRepository($modelClass);
        }

        return $this->repository;
    }
}
