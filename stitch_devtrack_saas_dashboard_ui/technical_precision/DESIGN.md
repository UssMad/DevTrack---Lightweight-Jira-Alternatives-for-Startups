---
name: Technical Precision
colors:
  surface: '#0f131b'
  surface-dim: '#0f131b'
  surface-bright: '#353942'
  surface-container-lowest: '#0a0e16'
  surface-container-low: '#181c24'
  surface-container: '#1c2028'
  surface-container-high: '#262a32'
  surface-container-highest: '#31353e'
  on-surface: '#dfe2ee'
  on-surface-variant: '#c7c4d7'
  inverse-surface: '#dfe2ee'
  inverse-on-surface: '#2c3039'
  outline: '#908fa0'
  outline-variant: '#464554'
  surface-tint: '#c0c1ff'
  primary: '#c0c1ff'
  on-primary: '#1000a9'
  primary-container: '#8083ff'
  on-primary-container: '#0d0096'
  inverse-primary: '#494bd6'
  secondary: '#adc6ff'
  on-secondary: '#002e6a'
  secondary-container: '#0566d9'
  on-secondary-container: '#e6ecff'
  tertiary: '#ddb7ff'
  on-tertiary: '#490080'
  tertiary-container: '#b76dff'
  on-tertiary-container: '#400071'
  error: '#ffb4ab'
  on-error: '#690005'
  error-container: '#93000a'
  on-error-container: '#ffdad6'
  primary-fixed: '#e1e0ff'
  primary-fixed-dim: '#c0c1ff'
  on-primary-fixed: '#07006c'
  on-primary-fixed-variant: '#2f2ebe'
  secondary-fixed: '#d8e2ff'
  secondary-fixed-dim: '#adc6ff'
  on-secondary-fixed: '#001a42'
  on-secondary-fixed-variant: '#004395'
  tertiary-fixed: '#f0dbff'
  tertiary-fixed-dim: '#ddb7ff'
  on-tertiary-fixed: '#2c0051'
  on-tertiary-fixed-variant: '#6900b3'
  background: '#0f131b'
  on-background: '#dfe2ee'
  surface-variant: '#31353e'
typography:
  display:
    fontFamily: Geist
    fontSize: 48px
    fontWeight: '700'
    lineHeight: '1.1'
    letterSpacing: -0.02em
  h1:
    fontFamily: Geist
    fontSize: 32px
    fontWeight: '600'
    lineHeight: '1.2'
    letterSpacing: -0.02em
  h2:
    fontFamily: Geist
    fontSize: 24px
    fontWeight: '600'
    lineHeight: '1.3'
    letterSpacing: -0.01em
  h3:
    fontFamily: Geist
    fontSize: 18px
    fontWeight: '600'
    lineHeight: '1.4'
    letterSpacing: '0'
  body-lg:
    fontFamily: Geist
    fontSize: 16px
    fontWeight: '400'
    lineHeight: '1.6'
    letterSpacing: '0'
  body-md:
    fontFamily: Geist
    fontSize: 14px
    fontWeight: '400'
    lineHeight: '1.5'
    letterSpacing: '0'
  label-sm:
    fontFamily: Geist
    fontSize: 12px
    fontWeight: '500'
    lineHeight: '1'
    letterSpacing: 0.02em
  code:
    fontFamily: jetbrainsMono
    fontSize: 13px
    fontWeight: '400'
    lineHeight: '1.5'
    letterSpacing: '0'
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  base: 8px
  xs: 4px
  sm: 8px
  md: 16px
  lg: 24px
  xl: 48px
  gutter: 20px
  margin: 32px
---

## Brand & Style
This design system is engineered for the high-performance developer workflow, prioritizing clarity, speed, and focus. The aesthetic is rooted in **Minimalism** with a heavy influence from **Glassmorphism** to create a sense of depth without clutter. 

The goal is to evoke a "flow state" by reducing visual noise. We utilize high-contrast functional elements against a deep, low-contrast background architecture. The interface should feel like a sophisticated IDE—utilitarian, responsive, and powerful. Key brand attributes include technical rigor, reliability, and streamlined efficiency.

## Colors
The palette is built on a "Deep Dark" foundation to reduce eye strain during long sessions. 

- **Primary Actions:** Use a gradient transition between Indigo (#6366F1) and Blue (#3B82F6).
- **Background Strategy:** The base layer is `#0B0E14`. Secondary layout sections (sidebars) use `#151921`.
- **Surfaces:** Floating elements and cards use `#1E232D` with a subtle 1px border.
- **Accents:** Use Purple (#A855F7) sparingly for AI features or special highlights.
- **Functional:** Colors are saturated to ensure they pop against the dark background, providing immediate semantic meaning for task status and priority.

## Typography
This design system utilizes **Geist** for its typeface to maintain a clean, technical, and developer-centric atmosphere. 

- **Hierarchy:** Use heavy weights (600-700) for headers to create clear entry points in data-dense screens.
- **Tabular Figures:** Ensure the font is set to use tabular (monospaced) numbers where possible, especially in project timelines and estimation counts.
- **Micro-copy:** Use `label-sm` in all-caps or medium weights for metadata and badges to distinguish them from interactive body text.

## Layout & Spacing
The layout follows a **Fluid Grid** model based on an 8px scale. 

- **Grid:** A 12-column system is used for main dashboards. Gutters are fixed at 20px to maintain breathing room between dense data cards.
- **Padding:** Use `md` (16px) for internal card padding and `sm` (8px) for tight component grouping (e.g., button groups).
- **Alignment:** All elements must snap to the 8px grid to ensure visual rhythm and pixel-perfection, echoing the precision of the codebases the users manage.

## Elevation & Depth
Depth is created through **Tonal Layering** and **Glassmorphism** rather than traditional heavy shadows.

- **Layer 0 (Base):** `#0B0E14` - The application canvas.
- **Layer 1 (Sub-navigation):** `#151921` - Used for sidebars or secondary panels.
- **Layer 2 (Cards/Modals):** `#1E232D` - The primary interaction surface.
- **Border Treatment:** Every elevated surface features a 1px solid border using `rgba(255, 255, 255, 0.08)` to define edges against the dark background.
- **Glass Effects:** Overlays and dropdowns use a background blur (20px) with a semi-transparent fill (`#1E232DCC`) to maintain context of the underlying data.
- **Shadows:** Use a single, extra-diffused shadow for modals: `0 20px 40px rgba(0,0,0,0.4)`.

## Shapes
The shape language balances approachability with technical structure. 

- **Standard Radius:** 8px (0.5rem) is the baseline for buttons, inputs, and small cards.
- **Large Radius:** 12px (0.75rem) is used for primary dashboard containers and modals.
- **Interactive States:** Maintain consistent corner radii across all states (hover, active, disabled) to prevent visual jarring during high-speed interaction.

## Components
Consistent implementation of these core components ensures the design system remains cohesive:

- **Buttons:** 
  - *Primary:* Indigo-to-Blue gradient background, white text, 8px radius. 
  - *Secondary:* Ghost style with the 1px white-alpha border and a subtle hover lift.
- **Status Badges:** Use a "dot" indicator + text layout. The background should be a low-opacity version (15%) of the functional color (e.g., Green-15% for "Done").
- **Input Fields:** Darker than the surface (`#0B0E14`), 1px border that glows Primary Indigo on focus. Use monospaced fonts for IDs and hash values.
- **Cards:** No external shadows. Use the 1px border treatment and 12px corner radius. Group related data with subtle horizontal separators (`rgba(255,255,255,0.05)`).
- **Progress Bars:** Thin 4px tracks with a glowing gradient fill to indicate task completion.
- **Command Palette:** A centered, glassmorphic modal with high backdrop blur, emphasizing search-first navigation.