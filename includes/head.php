<?php
/**
 * Sección HEAD común para todas las páginas
 */
?>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    sans: ["Inter", "sans-serif"],
                },
                colors: {
                    primary: "#000000",
                    secondary: "#ffffff",
                },
            },
        },
    };
</script>
