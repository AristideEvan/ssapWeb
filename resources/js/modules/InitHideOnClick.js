// usage
/* 
<button id="HideButton">HideDiv</button>
<div data-hide="#HideButton" data-if="posiiton:absolute"></div>
*/

export function InitHideOnClick() {
    $('[data-hide]').each(function() {
        var controlleur = $(this).data('hide');
        const $target = $(this);
        var targetElement = controlleur === 'windows' ? $(window) : $(controlleur);
        const condition = $(this).data('if');
        const [cssProperty, cssValue] = condition.split(':');
        targetElement.off('click').on('click', function() {
            const computedStyle = window.getComputedStyle(this);
            if ((cssProperty && cssValue) && computedStyle.getPropertyValue(cssProperty) ==
                cssValue) {
                $target.removeClass('d-md-block');
            }
        });



    });
}
$(document).ready(function() {
    InitHideOnClick();
});