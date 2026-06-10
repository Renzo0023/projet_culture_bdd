<?php
require_once __DIR__ . '/includes/header.php';
?>

<!-- HERO -->
<section class="bg-gradient-to-r from-blue-700 to-indigo-800 text-white rounded-2xl shadow-xl p-10 mb-10">
    <div class="max-w-4xl mx-auto text-center">

        <h1 class="text-5xl font-extrabold mb-6">
            La Littérature Marocaine d'Expression Française
        </h1>

        <p class="text-xl leading-relaxed text-blue-100">
            Découvrez les auteurs qui ont marqué la littérature marocaine,
            explorez leurs romans et plongez dans des récits qui racontent
            l'histoire, les traditions, les rêves et les transformations du Maroc.
        </p>

        <div class="mt-8 flex justify-center gap-4 flex-wrap">
            <a href="/projet_culture_bdd/recherche.php?type=auteur"
               class="bg-white text-blue-700 hover:bg-blue-50 font-bold py-3 px-6 rounded-full shadow-lg">
                Voir les auteurs
            </a>

            <a href="/projet_culture_bdd/recherche.php?type=roman"
               class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-3 px-6 rounded-full shadow-lg">
                Découvrir les romans
            </a>
        </div>

    </div>
</section>

<!-- IMPORTANCE DE LA LECTURE -->
<section class="bg-white rounded-xl shadow-md border border-gray-200 p-8 mb-10">
    <h2 class="text-3xl font-bold text-center text-blue-800 mb-6">
        Pourquoi lire ?
    </h2>

    <div class="grid md:grid-cols-3 gap-6">

        <div class="text-center">
            <div class="text-5xl mb-3">🧠</div>
            <h3 class="font-bold text-lg mb-2">Développer sa réflexion</h3>
            <p class="text-gray-600">
                La lecture stimule l'esprit critique, enrichit le vocabulaire
                et améliore les capacités d'analyse.
            </p>
        </div>

        <div class="text-center">
            <div class="text-5xl mb-3">🌍</div>
            <h3 class="font-bold text-lg mb-2">Découvrir le monde</h3>
            <p class="text-gray-600">
                Chaque roman ouvre une fenêtre sur une culture,
                une époque ou une expérience humaine différente.
            </p>
        </div>

        <div class="text-center">
            <div class="text-5xl mb-3">❤️</div>
            <h3 class="font-bold text-lg mb-2">Développer l'empathie</h3>
            <p class="text-gray-600">
                Les histoires nous permettent de comprendre les émotions,
                les parcours et les réalités des autres.
            </p>
        </div>

    </div>
</section>

<!-- GRANDES ŒUVRES -->
<section class="mb-10">

    <h2 class="text-3xl font-bold text-center text-indigo-800 mb-8">
        Quelques œuvres incontournables
    </h2>

    <div class="grid md:grid-cols-3 gap-6">

        <!-- La Boîte à Merveilles -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden hover:shadow-xl transition duration-300">

            <img
                src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjeq471c8PPwud2GFJnf-FWUCPTwI-2YIO8rECl1cQc4JojLzCvtZAGkrUeIo7VntJahWJMPdqbqPNlio6WRGpKDUq2m4GIDqWOiAHZBu-5oOoV1OzZ2IfhtWkhv6RXg5iBCuLSf6qNexibk9u2sxfx6-sCxl2arLpHhz2qpzBWCFPA6WIkPcbGBZ55EQ/s1024/la%20boite%20a%20merveilles.jpg"
                alt="La Boîte à Merveilles"
                class="w-full h-[450px] object-contain bg-gray-50 p-2"
            >

            <div class="p-6">
                <h3 class="text-xl font-bold text-indigo-700 mb-2">
                    La Boîte à Merveilles
                </h3>

                <p class="text-sm text-gray-500 mb-3">
                    Ahmed Sefrioui
                </p>

                <p class="text-gray-700">
                    Un classique de la littérature marocaine qui raconte
                    l'enfance dans la médina de Fès.
                </p>
            </div>

        </div>

        <!-- Le Passé Simple -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden hover:shadow-xl transition duration-300">

            <img
                src="https://static.fnac-static.com/multimedia/Images/FD/Comete/82933/CCP_IMG_ORIGINAL/1043749.jpg"
                alt="Le Passé Simple"
                class="w-full h-[450px] object-contain bg-gray-50 p-2"
            >

            <div class="p-6">
                <h3 class="text-xl font-bold text-indigo-700 mb-2">
                    Le Passé Simple
                </h3>

                <p class="text-sm text-gray-500 mb-3">
                    Driss Chraïbi
                </p>

                <p class="text-gray-700">
                    Une œuvre majeure qui interroge la tradition,
                    l'autorité et les mutations de la société marocaine.
                </p>
            </div>

        </div>

        <!-- L'Enfant de Sable -->
        <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden hover:shadow-xl transition duration-300">

            <img
                src="https://tse4.mm.bing.net/th/id/OIP.orBwgE1cTGl6_ZVPGEY1TQAAAA?rs=1&pid=ImgDetMain&o=7&rm=3"
                alt="L'Enfant de Sable"
                class="w-full h-[450px] object-contain bg-gray-50 p-2"
            >

            <div class="p-6">
                <h3 class="text-xl font-bold text-indigo-700 mb-2">
                    L'Enfant de Sable
                </h3>

                <p class="text-sm text-gray-500 mb-3">
                    Tahar Ben Jelloun
                </p>

                <p class="text-gray-700">
                    Un roman emblématique explorant l'identité,
                    le genre et les traditions sociales.
                </p>
            </div>

        </div>

    </div>

</section>

<!-- Auteurs emblématiques -->
<section class="mt-16">
    <h3 class="text-3xl font-bold text-center text-blue-800 mb-8">
        Quelques auteurs incontournables
    </h3>

    <div class="grid md:grid-cols-3 gap-8">

        <!-- Ahmed Sefrioui -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
            <img
                src="https://www.oujdacity.net/thumbs/r800/data/images/20071027-165822-oujda-ahmed-sefrioui.jpg"
                alt="Ahmed Sefrioui"
                class="block mx-auto w-80 h-80 rounded-full object-cover border-4 border-blue-100 shadow-md mb-5"
            >
            <div class="p-5">
                <h4 class="text-xl font-bold text-blue-800 mb-2">
                    Ahmed Sefrioui
                </h4>

                <p class="text-gray-700 text-sm leading-relaxed">
                    Considéré comme l’un des pionniers du roman marocain
                    d’expression française, il est notamment l’auteur de
                    <em>La Boîte à merveilles</em>, œuvre étudiée dans de
                    nombreux établissements scolaires.
                </p>
            </div>
        </div>

        <!-- Driss Chraïbi -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
            <img
                src="https://imagenes.elpais.com/resizer/QeDf3QjJPSul-fOVGBZzrurkmmM=/1960x0/arc-anglerfish-eu-central-1-prod-prisa.s3.amazonaws.com/public/W76ZOK26MFQMFF6T2YOLF5QJSA.jpg"
                alt="Driss Chraïbi"
                class="block mx-auto w-80 h-80 rounded-full object-cover border-4 border-blue-100 shadow-md mb-5"
            >
            <div class="p-5">
                <h4 class="text-xl font-bold text-blue-800 mb-2">
                    Driss Chraïbi
                </h4>

                <p class="text-gray-700 text-sm leading-relaxed">
                    Écrivain majeur du XXe siècle, il a marqué la littérature
                    maghrébine grâce à son regard critique sur la société,
                    notamment dans <em>Le Passé simple</em>.
                </p>
            </div>
        </div>

        <!-- Tahar Ben Jelloun -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
            <img
                src="https://img-4.linternaute.com/6L1MImzWqnLxbb8H3eB6SX2T9bk=/1240x/smart/2965e292ce4b48e08938b3c19ca0940f/ccmcms-linternaute/11118679.jpg"
                alt="Tahar Ben Jelloun"
                class="block mx-auto w-80 h-80 rounded-full object-cover border-4 border-blue-100 shadow-md mb-5"
            >
            <div class="p-5">
                <h4 class="text-xl font-bold text-blue-800 mb-2">
                    Tahar Ben Jelloun
                </h4>

                <p class="text-gray-700 text-sm leading-relaxed">
                    Lauréat du Prix Goncourt en 1987, il est l’un des auteurs
                    marocains les plus traduits dans le monde. Ses œuvres
                    abordent les questions d’identité, de mémoire et de liberté.
                </p>
            </div>
        </div>

    </div>
</section>

<section class="mt-16 bg-gradient-to-r from-indigo-50 to-blue-50 py-6 rounded-2xl shadow-inner">

    <h3 class="text-3xl font-bold text-center text-indigo-800 mb-8">
        Le coin du lecteur
    </h3>

    <div class="flex flex-col items-center text-center max-w-3xl mx-auto px-6">

        <img
            src="https://i.pinimg.com/originals/91/3f/79/913f79ac6c47e3a06f19563177afd7be.png"
            alt="Rat de bibliothèque"
            class="w-56 h-56 object-contain mb-6 hover:scale-105 transition duration-300"
        />

        <p class="text-lg text-gray-700 leading-relaxed italic">
            “Un bon lecteur n’est jamais seul : il vit mille vies à travers les livres.
            Chaque page tournée est une porte ouverte sur un nouveau monde.”
        </p>

    </div>

</section>

<!-- CITATION -->
<section class="bg-blue-50 border-l-4 border-blue-600 p-8 rounded-xl mb-10">

    <blockquote class="text-2xl italic text-gray-700 text-center">
        « Lire, c'est voyager sans bouger, comprendre sans juger
        et grandir sans limite. »
    </blockquote>

</section>

<!-- APPEL À L'ACTION -->
<section class="text-center bg-white rounded-xl shadow-md border border-gray-200 p-6">

    <h2 class="text-3xl font-bold text-blue-800 mb-4">
        Commencez votre exploration
    </h2>

    <p class="text-gray-600 mb-6">
        Parcourez notre collection d'auteurs et de romans
        pour découvrir toute la richesse de la littérature marocaine.
    </p>

    <a href="/projet_culture_bdd/recherche.php?type=roman"
       class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-full shadow-lg transition duration-300">
        Explorer la collection
    </a>

</section>

<?php
require_once __DIR__ . '/includes/footer.php';
?>