    var g = new Bluff.Line('<?php echo "$id" ?>', '100x15');
    g.set_theme({
        colors: ['blue'],
        font_color: 'black',
        background_colors: ['#fafafa', '#f0f0f0']
    });
    g.line_width = 1;
    g.tooltips = true;
    g.dot_radius = 15;
    g.hide_mini_legend = true;
    g.hide_legend = true;
    g.hide_line_markers = true;
    g.hide_line_numbers = true;
    g.hide_title = true;
    g.set_font('Georgia');
    g.data("<?php echo __('votos positivos') ?>", [<?php echo $sparklineData ?>]);
    g.draw();
