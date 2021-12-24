<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Group;
use App\Entity\Media;
use App\Entity\Trick;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    private $slugger;

    public function __construct(UserPasswordHasherInterface $hasher, SluggerInterface $slugger)
    {
        $this->hasher = $hasher;
        $this->slugger = $slugger;    
    }
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user
            ->setPseudo('admin')
            ->setEmail('admin@snowtricks.com')
            ->setPassword($this->hasher->hashPassword($user, '123456'))
            ->setIsValidated(1)
        ;

        $manager->persist($user);

        $tricks = [
            //1
            [
                "name" => "Backflip",
                "thumbnail" => "1-backflip.jpg",
                "group" => "Flip",
                "description" => "
                1- Le mieux c’est de s’entrainer à le faire sur un trampoline car le mouvement est le même.
                <br>
                2- Choisissez un kicker de bord de piste, qui kicke un peu de préférence, pour vous aider à envoyer facilement
                <br>
                3- Arrivez bien fléchi en appui sur les 2 jambes et fixez le bout du kicker. L’impulsion se fait à 2 pieds au bout du kicker et pas avant : si on envoie trop tôt on risque de taper la tête dans le kicker ou de trop tourner, de faire un tour et demi et de tomber sur la tête. Deux situations à éviter...
                <br>
                4- Donc impulsion à deux pieds, et on envoie la tête en arrière pour chercher le mouvement. Dès que l’on a décollé il faut remonter les genoux pour enrouler le mouvement. Les profs de gym ont tendance à dire que l’on envoie le mouvement avec le bassin, ce qui n’est pas faux mais c’est surtout quand on a compris le mouvement et que l’on est à l’aise avec.
                <br>
                5- Donc regrouper les jambes en les montant. A ce moment on peut aussi penser à grabber mais ce n’est pas obligé pour commencer... On continue d’emmener la rotation avec la tête en arrière.
                <br>
                6- Très vite on peut voir la réception et on va pouvoir gérer la fin de al rotation soit en se tendant un peu pour la ralentir, soit en se regroupant encore davantage pour tourner plus vite.
                <br>
                7- Replacez bien la board sous votre corps avant d’atterrir, et amortir en pliant les jambes",
                "images" => [
                    "2-backflip.jpg",
                    "3-backflip.jpg"
                ],
                "videos" => [
                    '<iframe src="https://www.youtube.com/embed/SlhGVnFPTDE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                    '<iframe src="https://www.youtube.com/embed/arzLq-47QFA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
                ]
            ],
            //2
            [
                "name" => "Frontflip",
                "thumbnail" => "1-frontflip.jpg",
                "group" => "Flip",
                "description" => "
                1- Le mieux c’est de s’entrainer à le faire sur un trampoline car le mouvement est le même.
                <br>
                2- Choisissez un kicker de bord de piste, qui kicke un peu de préférence, pour vous aider à envoyer facilement
                <br>
                3- Arrivez bien fléchi en appui sur les 2 jambes et fixez le bout du kicker. L’impulsion se fait à 2 pieds au bout du kicker et pas avant : si on envoie trop tôt on risque de taper la tête dans le kicker ou de trop tourner, de faire un tour et demi et de tomber sur la tête. Deux situations à éviter...
                <br>
                4- Donc impulsion à deux pieds, et on envoie la tête en avant pour chercher le mouvement. Dès que l’on a décollé il faut remonter les genoux pour enrouler le mouvement. Les profs de gym ont tendance à dire que l’on envoie le mouvement avec le bassin, ce qui n’est pas faux mais c’est surtout quand on a compris le mouvement et que l’on est à l’aise avec.
                <br>
                5- Donc regrouper les jambes en les montant. A ce moment on peut aussi penser à grabber mais ce n’est pas obligé pour commencer... On continue d’emmener la rotation avec la tête en avant.
                <br>
                6- Très vite on peut voir la réception et on va pouvoir gérer la fin de al rotation soit en se tendant un peu pour la ralentir, soit en se regroupant encore davantage pour tourner plus vite.
                <br>
                7- Replacez bien la board sous votre corps avant d’atterrir, et amortir en pliant les jambes",
                "images" => [
                    "2-frontflip.jpg",
                    "3-frontflip.jpg"
                ],
                "videos" => [
                    '<iframe src="https://www.youtube.com/embed/eGJ8keB1-JM" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                    '<iframe src="https://www.youtube.com/embed/xhvqu2XBvI0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
                ]
            ],
            //3
            [
                "name" => "Backside 180",
                "thumbnail" => "1-180backside.jpg",
                "group" => "Rotation",
                "description" => "
                1 - La phase d’approche consiste à avoir sa planche la plus à plat possible ou légèrement sur la carre frontside ; le regard est pointé vers le spot (l’endroit où on veut décoller). Les jambes sont fléchies, prêtes à donner une impulsion.
                <br>
                2 - L’impulsion : on a le choix entre un ollie façon skate (comme on peut le voir dans notre tuto sur le Ollie) et une impulsion franche à deux pieds. L’impulsion à deux pieds conviendra mieux sur un kicker de park alors qu’un ollie plus skate et un peu sur la carre est plus évident en bord de piste. Donc on envoie une impulsion  en enclenchant très doucement les épaules de 30°.
                <br>
                3 - Engager la rotation à l’aveugle, de dos… pas de panique, l’astuce est de regarder votre pied arrière pour voir défiler le sol en dessous et permettre au corps de faire un 180° progressif. Attendez de voir la réception pour ajuster la board  tout en gardant les épaules dans l’axe de la planche ou légèrement en retard pour bien arrêter la rotation.
                <br>
                4 - En réception : bien amortir sur les jambes, continuer de regarder entre les pieds pour garder l’équilibre. Ce n’est qu’une fois que l'on a bien amorti qu'on pourra relever la tête et regarder ou l'on va…",
                "images" => [
                    "2-180backside.jpg",
                    "3-180backside.jpg"
                ],
                "videos" => [
                    '<iframe src="https://www.youtube.com/embed/Sj7CJH9YvAo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                    '<iframe src="https://www.youtube.com/embed/xhvqu2XBvI0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
                ]
            ],
            //4
            [
                "name" => "Backside 360",
                "thumbnail" => "1-360backside.jpg",
                "group" => "Rotation",
                "description" => "
                Le 3.6 back, comment ça marche:
                <br>
                1 - La phase d’approche consiste à arriver bien fléchi sur le kicker, en appui léger sur les pointes de pieds, les épaules dans l’axe de la board, le regard bien fixé sur le bout du kicker. Pour débuter mieux vaut choisir de petits kickers de bord de pistes, on peut s'aider en arrivant légèrement en courbe dans le kick pour lancer la rotation.
                <br>
                2 - L'impulsion se fait à 2 pieds au bout du kicker. Inutile de pousser trop fort aux premiers essais, au risque d’être déséquilibré. Donc impulsion à 2 pieds en lançant la rotation avec les épaules et la tête de 90° dégrés vers l’arrière, rapidement sur un mini saut et plus lentement en proportion avec l’augmentation de la taille du saut. Le menton doit se retrouver au niveau de votre épaule, le regard par dessus l’épaule.
                <br>
                3 - Un fois en l’air, garder la même position des épaules et regrouper les jambes. Quand on devient plus à l’aise avec le mouvement, on peut grabber la board. 
                <br>
                4 - Chercher la réception du regard, on peut l'apercevoir assez vite. Une fois qu'on la voit, on ne la lâche pas des yeux. Ça permet d'ajuster la vitesse de rotation en fonction de la distance qu’il reste à parcourir en tournant plus ou moins les épaules vers la réception.
                <br>
                5 - Quand la réception arrive, ramener le bas du corps qui est resté un peu en retard par rapport au regard et aux épaules. Plus on se regroupe et plus la rotation peut s’accélérer si besoin.
                <br>
                6 - Pour atterrir, bien regarder la réception et ce qui arrive devant, détendre légèrement les jambes pour aller chercher le sol avec les 2 pieds, et amortir en appui sur les deux jambes. Regarder où on va seulement après avoir plaqué. Vous pouvez s'aider un peu à amortir en posant légèrement le tail en premier, mais attention au risque de partir en arrière.
                <br>
                Et voilà à vous de jouer, le 3.6 back est facile et amusant, on peut le placer à beaucoup d’endroits, sa vitesse de rotation étant très facile à gérer on peut en faire sur toute taille de jumps, que se soit en bord de piste, en backcountry ou sur des kickers de park du S au XXL. Et comme on voit la réception les 3 dernier quarts du saut, c’est très rassurant et du coup plus facile à replaquer…",
                "images" => [
                    "2-360backside.jpg",
                    "3-360backside.jpg"
                ],
                "videos" => [
                    '<iframe src="https://www.youtube.com/embed/hUQ3eKS13co" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                    '<iframe src="https://www.youtube.com/embed/RUiWxRCAvLs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
                ]
            ],
            //5
            [
                "name" => "Indy",
                "thumbnail" => "1-grab.jpg",
                "group" => "Grab",
                "description" => "
                Il faut d'abord faire un saut, un simple ollie par exemple comme on peut le voir sur le tuto du ollie. Bien plier les jambes une fois en l’air pour se regrouper, et aller chercher la planche avec la main. Attention il ne faut pas que le buste se casse en deux pour aller chercher la board : ce sont bien les genoux qui remontent pour amener la board vers la main.
                <br>
                <br>
                1 - la main arrière vient graber la carre frontside entre les pieds. Sur un saut droit c’est un Indy Grab, sur un hip ou un quarter en front c’est un frontside indy ou frontside grab alors que sur un saut en back (3.6 back par exemple) ça sera un backside Indy.
                <br>
                <br>
                Attention aux zones dites de grabs interdits qui se trouvent entre les spatules et les fixations, il faut avoir beaucoup de style pour s’y risquer et que ça soit joli, un peu comme Shaun White avec ses grabs de boots et de fixations...",
                "images" => [
                    "2-grab.jpg",
                    "3-grab.jpg"
                ],
                "videos" => [
                    '<iframe src="https://www.youtube.com/embed/Sj7CJH9YvAo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                    '<iframe src="https://www.youtube.com/embed/xhvqu2XBvI0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
                ]
            ],
            //6
            [
                "name" => "Ollie",
                "thumbnail" => "1-ollie.jpg",
                "group" => "Flip",
                "description" => "
                Le Ollie peut se décomposer en plusieurs phases :
                <br>
                1. La phase d’approche consiste à avoir sa planche la plus à plat possible ou légèrement sur la carre; le regard pointé vers le spot (l’endroit où on veut décoller). Les jambes sont fléchies, prêtes à donner une impulsion.
                <br>
                2. Pour déclencher le Ollie, il faut tirer sur la jambe avant tout en appuyant sur la jambe arrière pour déformer la planche et aller chercher le pop de son snowboard (le «rebond» de la planche). On peut s'aider des bras en les dépliants comme un oiseau qui cherche à s'envoler ;)
                <br>
                3. Dés que l’on sent qu’on décolle, il faut regrouper les jambes et les bras pour gagner en stabilité, le regard cherche déjà l’endroit où on va aller atterrir tout en essayant de profiter du moment présent…
                <br>
                4.  Pour atterrir, il faut légèrement détendre les jambes pour aller chercher le sol tout en préparant l’amorti, c’est à dire forcer sur les jambes qui servent d’amortisseur. Bien plier les genoux sans se laisser assoir par la force de gravité.
                <br>
                Le mieux c’est de commencer à s’entrainer à faire des ollies à plat sur la piste, puis en profitant des petits reliefs de bord de piste. Quand on se sent vraiment  à l’aise, on peut commencer à essayer sur de plus gros sauts (kickers de snowpark par exemple). Ne pas hésiter à être créatif, repérer toute variation de terrain qui peut être un bon spot pour envoyer un ollie, et transformer la montagne en terrain de jeu…",
                "images" => [
                    "2-ollie.jpg",
                    "3-ollie.jpg"
                ],
                "videos" => [
                    '<iframe src="https://www.youtube.com/embed/kOyCsY4rBH0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                    '<iframe src="https://www.youtube.com/embed/aAefkzI-zS0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
                ]
            ],
            //7
            [
                "name" => "Frontside 360",
                "thumbnail" => "1-360frontside.jpg",
                "group" => "Rotation",
                "description" => "
                Le 3.6 front ou frontside 3 est un tricks intéressant car on peut y mettre facilement beaucoup de style. C’est une rotation de 360 degrés du côté frontside ( à gauche pour les regular et à droite pour les goofy). Comme le 3.6 back, la vitesse de rotation est assez facile à gérer, mais si l’impulsion parait plus évidente en lançant les épaules de face, l’atterrissage l'est beaucoup moins car on est de dos le dernier quart du saut. On appelle ça une reception blind side…
                <br>
                Comment ça marche le frontside 360 ?
                <br>
                1 - La phase d’approche est similaire à tous les sauts : on arrive les jambes bien fléchies, les épaules dans l’axe de la board, le regard pointé vers le bout du kicker.
                <br>
                2 - L’impulsion peut se faire autant à 2 pieds qu’en ollie façon skate. Les petits 3.6 de bord de piste se font quasi obligatoirement en ollie tandis qu'on aura tendance à plus pousser avec les deux pieds sur un kicker de park. Impulsion donc, en lançant la rotation avec la tête et les épaules vers l’avant de la board. Le menton au niveau de l'épaule, le regard juste par dessus l’épaule. Lancer les épaules plus ou moins fort en fonction de la taille du saut.
                <br>
                3 - Dès que l'on décolle, on regroupe les jambes. On peut garder les bras ouvert pour contrôler la vitesse de rotation ou grabber si on est plus à l’aise avec le tricks. On peut aussi tweaker pour mettre du style ou ralentir la rotation. Pour l’accélérer de nouveau, il suffit de lâcher le grab et se regrouper.
                <br>
                4 - On doit apercevoir la réception par dessus son épaule après le premier demi tour. Quand on voit l’endroit ou on pense atterri passer sous l'épaule puis sous la board, il vous faut se regrouper, les épaules dans l’axe de la board et le tout dans l’axe de la réception.
                <br>
                5 - Replaquer en regardant bien ses pieds pour être sûr que la rotation s’arrête. Le défaut le plus commun est de regarder devant au moment ou on atterrit, du coup sans en avoir conscience les  épaules ont fait quelques degrés de plus et ça déséquilibre  le landing... Donc réceptionner bien en appui sur les deux pieds, en regardant ses pieds, et ne relever la tête qu’une fois que l'on a bien amorti. 
                <br>
                Le 3.6 front se fait aussi en switch, c’est alors un cab 3.6. Les deux versions sont toutes les deux très faciles en bord de piste sur des petits sauts. On peut se lancer en 3.6 front sur de plus gros kickers dès que l'on a bien le mouvement et qu'on se sent à l’aise en l’air avec ses repères. Essayer ensuite en switch quand on sait déjà très bien rider en switch… L'important est comme toujours de bien repérer le spot avant de se lancer. 
                <br>
                Amusez vous bien en faisant des 360 frontside avec tous les grabs légaux possibles, ou ceux de votre invention, mais attention, la police du style veille !",
                "images" => [
                    "2-360frontside.jpg",
                    "3-360frontside.jpg"
                ],
                "videos" => [
                    '<iframe src="https://www.youtube.com/embed/9T5AWWDxYM4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                    '<iframe src="https://www.youtube.com/embed/hUddT6FGCws" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
                ]
            ],
            //8
            [
                "name" => "Nose grab",
                "thumbnail" => "1-nosegrab.jpg",
                "group" => "Grab",
                "description" => "
                Le 3.6 front ou frontside 3 est un tricks intéressant car on peut y mettre facilement beaucoup de style. C’est une rotation de 360 degrés du côté frontside ( à gauche pour les regular et à droite pour les goofy). Comme le 3.6 back, la vitesse de rotation est assez facile à gérer, mais si l’impulsion parait plus évidente en lançant les épaules de face, l’atterrissage l'est beaucoup moins car on est de dos le dernier quart du saut. On appelle ça une reception blind side…
                <br>
                Comment ça marche le frontside 360 ?
                <br>
                1 - La phase d’approche est similaire à tous les sauts : on arrive les jambes bien fléchies, les épaules dans l’axe de la board, le regard pointé vers le bout du kicker.
                <br>
                2 - L’impulsion peut se faire autant à 2 pieds qu’en ollie façon skate. Les petits 3.6 de bord de piste se font quasi obligatoirement en ollie tandis qu'on aura tendance à plus pousser avec les deux pieds sur un kicker de park. Impulsion donc, en lançant la rotation avec la tête et les épaules vers l’avant de la board. Le menton au niveau de l'épaule, le regard juste par dessus l’épaule. Lancer les épaules plus ou moins fort en fonction de la taille du saut.
                <br>
                3 - Dès que l'on décolle, on regroupe les jambes. On peut garder les bras ouvert pour contrôler la vitesse de rotation ou grabber si on est plus à l’aise avec le tricks. On peut aussi tweaker pour mettre du style ou ralentir la rotation. Pour l’accélérer de nouveau, il suffit de lâcher le grab et se regrouper.
                <br>
                4 - On doit apercevoir la réception par dessus son épaule après le premier demi tour. Quand on voit l’endroit ou on pense atterri passer sous l'épaule puis sous la board, il vous faut se regrouper, les épaules dans l’axe de la board et le tout dans l’axe de la réception.
                <br>
                5 - Replaquer en regardant bien ses pieds pour être sûr que la rotation s’arrête. Le défaut le plus commun est de regarder devant au moment ou on atterrit, du coup sans en avoir conscience les  épaules ont fait quelques degrés de plus et ça déséquilibre  le landing... Donc réceptionner bien en appui sur les deux pieds, en regardant ses pieds, et ne relever la tête qu’une fois que l'on a bien amorti. 
                <br>
                Le 3.6 front se fait aussi en switch, c’est alors un cab 3.6. Les deux versions sont toutes les deux très faciles en bord de piste sur des petits sauts. On peut se lancer en 3.6 front sur de plus gros kickers dès que l'on a bien le mouvement et qu'on se sent à l’aise en l’air avec ses repères. Essayer ensuite en switch quand on sait déjà très bien rider en switch… L'important est comme toujours de bien repérer le spot avant de se lancer. 
                <br>
                Amusez vous bien en faisant des 360 frontside avec tous les grabs légaux possibles, ou ceux de votre invention, mais attention, la police du style veille !",
                "images" => [
                    "2-nosegrab.jpg",
                    "3-nosegrab.jpg"
                ],
                "videos" => [
                    '<iframe src="https://www.youtube.com/embed/gZFWW4Vus-Q" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                    '<iframe src="https://www.youtube.com/embed/mfm3a3og3LI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
                ]
            ],
            //9
            [
                "name" => "Switch back 540",
                "thumbnail" => "1-540switchback.jpg",
                "group" => "Flip",
                "description" => "
                1 - Avant tout, il faut bien maitriser le fait de rider en switch avec aisance ainsi que le switch 180 back pour l’arrivé sur le kick et les 360 front pour la fin de la rotation et le replaquage.
                <br>
                2 - La phase d’approche consiste à arriver bien fléchi sur le kicker, la planche bien à plat, les épaules dans l’axe de la board, le regard fixé sur le bout du kicker.
                <br>
                3 - L’impulsion se fait à 2 pieds au bout du kicker, en lançant la rotation avec les épaules. Ne pas pousser trop fort aux premiers essais au risque d’être déséquilibré. La vitesse à laquelle il faut lancer les épaules pour lancer la rotation dépend de la taille du saut évidement… Le mieux est de commencer par un saut d’environ 5m, sa suffit pour tourner ce tricks.
                <br>
                4 - Pour que la rotation se fasse à plat, il faut lancer le mouvement avec  les épaules à l’horizontale. Le regard se porte par dessus l’épaule, le menton au niveau de l’épaule. Pour désaxer, c’est la tête qui va chercher à twister le mouvement, et les épaules ne seront plus à l’horizontale.
                <br>
                5 - Dès que l’on est en l’air, se regrouper et grabber. On vous conseille le Melon Grab pour commencer, c’est le plus simple avec cette rotation.
                <br>
                6 - Il faut aller chercher la rotation du regard par dessus l’épaule avant. On aperçoit la reception après 270° et a partir de ce moment là c’est tout comme la fin d'un bon vieux 360 front. Il faut donc fixer des yeux la réception et ne pas la lâcher. Le mouvement est fini avec la tête tandis qu’il continue avec les épaules et le bas du corps restés en retard pour aller s’aligner vers la réception.
                <br>
                7 - Pour atterrir, il faut ramener le bas du corps dans l’axe de la réception en se regroupant si on a besoin d’accélérer le mouvement. On détend ses jambes pour aller chercher la réception puis amortir sur les deux jambes au contact du sol. Les épaules doivent être dans l’axe de la board ou légèrement en retard pour arrêter la rotation, surtout si on sent que l’on tournait trop vite, ça évite la sur-rotation. Regardez devant vous une fois que vous avez fini d’amortir.",
                "images" => [
                    "2-540switchback.jpg",
                    "3-540switchback.jpg"
                ],
                "videos" => [
                    '<iframe src="https://www.youtube.com/embed/wDoHk1Y6c-w" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                    '<iframe src="https://www.youtube.com/embed/szW8xTlpaAw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
                ]
            ],
            //10
            [
                "name" => "Rail",
                "thumbnail" => "1-540switchback.jpg",
                "group" => "Flip",
                "description" => "
                1 - pour commencer, préférer les boxes, plus faciles d'approche, en boardslide, 50/50 et frontboard. Le mieux est de trouver des boxes où on monte dessus, où on glisse directement, pas avec des kickers qui demandent un saut...
                <br>
                2 - ensuite on peut évoluer sur un tuyau ou une barrière un peu ronde une fois qu'on est à l'aise
                <br>
                3 - en cas de panique, penser à pousser sur les deux jambes pour s'éjecter le plus tôt possible
                <br>
                4 - on peut ensuite progresser vers le frontboard, ou on descend de dos au module
                <br>
                5 - dans tous les tricks de rail, le plus important est de garder la board le plus à plat possible, surtout ne pas se mettre sur la carre...",
                "images" => [
                    "2-540switchback.jpg",
                    "3-540switchback.jpg"
                ],
                "videos" => [
                    '<iframe src="https://www.youtube.com/embed/slWCAZijWTI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                    '<iframe src="https://www.youtube.com/embed/NeY6sSsbbZw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
                ]
            ],
            //11
            [
                "name" => "Tail Grab",
                "thumbnail" => "1-tailgrab.jpg",
                "group" => "Grab",
                "description" => "
                Il faut d'abord faire un saut, un simple ollie par exemple comme on peut le voir sur le tuto du ollie. Bien plier les jambes une fois en l’air pour se regrouper, et aller chercher la planche avec la main. Attention il ne faut pas que le buste se casse en deux pour aller chercher la board : ce sont bien les genoux qui remontent pour amener la board vers la main.
                <br>
                La main arrière grabbe le tail (la spatule arrière).
                <br>
                Attention aux zones dites de grabs interdits qui se trouvent entre les spatules et les fixations, il faut avoir beaucoup de style pour s’y risquer et que ça soit joli, un peu comme Shaun White avec ses grabs de boots et de fixations...",
                "images" => [
                    "2-tailgrab.jpg",
                    "3-tailgrab.jpg"
                ],
                "videos" => [
                    '<iframe src="https://www.youtube.com/embed/L4bIunv8fHM" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                    '<iframe src="https://www.youtube.com/embed/_Qq-YoXwNQY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
                ]
            ]
        ];

        foreach ($tricks as $trick) {
            $newTrick = new Trick;
            $newTrick->setName($trick['name']);
            $newTrick->setSlug($this->slugger->slug($newTrick->getName()));
            $newTrick->setDescription($trick['description']);
            $newTrick->setUser($user);

            $group = new Group();
            $group->setName($trick['group']);
            $group->addTrick($newTrick);

            $manager->persist($group);
            $thumbnail = new Media();
            $thumbnail->setLink($trick['thumbnail']);
            $thumbnail->setIsThumbnail(1);
            $thumbnail->setType("image");
            $thumbnail->setTrick($newTrick);

            $manager->persist($thumbnail);

            foreach ($trick['images'] as $image) {
                $newImage = new Media();
                $newImage->setLink($image);
                $newImage->setIsThumbnail(0);
                $newImage->setType("image");
                $newImage->setTrick($newTrick);

                $manager->persist($newImage);
            }

            foreach ($trick['videos'] as $video) {
                $newVideo = new Media();
                $newVideo->setLink($video);
                $newVideo->setIsThumbnail(0);
                $newVideo->setType("video");
                $newVideo->setTrick($newTrick);

                $manager->persist($newVideo);
            }

            $manager->persist($newTrick);
        }

        $manager->flush();
    }
}
