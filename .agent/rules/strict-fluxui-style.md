---
trigger: always_on
---

# Rule: Flux UI Documentation First
- **Source of Truth:** Siempre usa https://fluxui.dev/ como única referencia de diseño.
- **Workflow:** 1. Lee los requisitos del usuario.
    2. Busca el componente equivalente en la documentación de Flux UI.
    3. Si el componente no existe, créalo usando EXCLUSIVAMENTE los tokens de diseño (colores, espaciado) definidos en la instalación de Flux.
- **Strict Avoidance:** No inventes componentes que parezcan "estándar" pero que no sigan la sintaxis de Flux (ej. no uses `className="btn"` si Flux usa un componente `<Button>`).