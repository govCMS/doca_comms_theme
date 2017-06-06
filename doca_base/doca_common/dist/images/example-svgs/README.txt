----------
SVG README
----------

SVG's can be tricky to scale, particularly in IE9+
New SVG's should follow these rules to ensure consistent display:

1. Remove any Height and Width attributes from the <svg> tag
2. Ensure there is a Viewbox attribute ie. viewBox="0 0 50 100" (where 50 is the width and 100 is the height)
3. Add the following Preserve Aspect Ration attribute: preserveAspectRatio="xMidYMid meet"

These SVG's are rendered by the browser at 150x300 regardless of the viewBox, so if the
SVG is not used in an area that has been setup for it, you are likely to require setting
either a height OR width in the CSS to scale it (you shouldn't need both).

For more details please read: https://css-tricks.com/scale-svg/
