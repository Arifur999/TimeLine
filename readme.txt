=== Static Timeline Widget ===
Contributors: Arif
Tags: timeline, vertical timeline, static content, scroll animation
Requires at least: 5.5
Tested up to: 6.5
Requires PHP: 7.4
Stable tag: 1.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A fully customizable vertical timeline — card sizes, padding, font sizes, colors, icon size, responsive layout. No page builder needed.

== Description ==

**Static Timeline Widget v1.1.0** by [Arif](https://github.com/Arifur999)

Build beautiful alternating vertical timelines with full control over every size, spacing, color and font.

**What's New in v1.1.0:**
* ✅ Card padding control (top / right / bottom / left individually)
* ✅ Card max-width control
* ✅ Heading font size & weight
* ✅ Sub-heading font size
* ✅ Paragraph font size & line-height
* ✅ Date font size & weight
* ✅ Icon circle size
* ✅ Line thickness control
* ✅ Item gap & wrapper padding
* ✅ Improved responsive layout (tablet + mobile)
* ✅ CSS custom properties for zero-specificity overrides

**Core Features:**
* Custom Post Type for timeline items
* Date, Heading, Sub Heading, Paragraph fields
* Image & Icon upload (WordPress Media Library)
* Left / Right card positioning per item
* Display order control
* Scroll-triggered slide-in animation
* Progressive vertical line draw on scroll
* Security: nonce, capability checks, full sanitization

== Installation ==

1. Upload `static-timeline-plugin` folder to `/wp-content/plugins/`
2. Activate from Dashboard → Plugins
3. Go to Dashboard → Timeline → Add New Item
4. Add `[static_timeline]` to any page

== Shortcode Reference ==

Basic:
[static_timeline]

Full example:
[static_timeline
  accent_color="#c9982a"
  heading_size="20"
  paragraph_size="15"
  date_size="14"
  card_padding_top="30"
  card_padding_right="32"
  card_padding_bottom="30"
  card_padding_left="32"
  card_max_width="520"
  icon_size="58"
  line_width="2"
  animate="yes"
]

== Changelog ==

= 1.1.0 =
* Added: card_padding_top/right/bottom/left attributes
* Added: card_max_width attribute
* Added: heading_size, heading_weight attributes
* Added: sub_heading_size attribute
* Added: paragraph_size, paragraph_line_height attributes
* Added: date_size, date_weight attributes
* Added: icon_size attribute
* Added: line_width attribute
* Added: item_gap, wrapper_padding attributes
* Improved: responsive layout (mobile stacks cleanly)
* Improved: CSS variables for easier theme overrides

= 1.0.0 =
* Initial release
