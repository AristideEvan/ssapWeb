/* 
<button class="btn btn-primary" id="AsideToggler" data-toggle="popup" data-target="aside">
<span class="fas fa-list"></span>
</button>
<aside id="aside" class="d-none d-md-block p-3"></aside> 
*/
export function InitAsideToggle() {
    (function ($) {
        function injectCSS() {
            var styles = `
    @media (max-width: 768px) {
        .d-md-block {
            position: absolute !important;
        }
        #sommaire {
            z-index: 9999 !important;
            background-color: #fff !important;
        }
        .d-none {
            display: none !important;
        }
    }
`;

            var styleSheet = document.createElement("style");
            styleSheet.type = "text/css";
            styleSheet.innerText = styles;
            document.head.appendChild(styleSheet);
        }

        // Fonction pour initialiser l'affichage des popups (sommaire, etc.)
        function initPopupToggle() {
            $('[data-toggle="popup"]').each(function () {
                const $toggler = $(this);
                const targetId = $toggler.data("target");
                const $target = $("#" + targetId);

                // Gestion du clic sur le bouton
                $toggler.off("click").on("click", function () {
                    if (window.innerWidth <= 768) {
                        $target.toggleClass("d-none");
                    } else {
                        $target.toggleClass("d-md-block");
                    }
                });
            });
        }

        // Fonction pour détecter les petits écrans
        function tagSmallScreen() {
            if (window.innerWidth <= 768) {
                document.body.classList.add("small-screen");
            } else {
                document.body.classList.remove("small-screen");
            }
        }

        // Exécuter la fonction à la charge de la page et lors du redimensionnement
        $(document).ready(function () {
            injectCSS(); // Injecter le CSS
            initPopupToggle();
            tagSmallScreen();
        });

        $(window).on("resize", function () {
            tagSmallScreen();
        });
    })(jQuery);
}
