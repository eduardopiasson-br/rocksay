<meta name="description" content="{{ $site_description ?? $config->footer_text }}"/>
<meta name="twitter:card" value="summary">
<meta name="twitter:title" content="{{ $site_title ?? $title }}">
<meta name="twitter:description" content="{{ $site_description ?? $config->footer_text }}">
<meta name="twitter:image" content="{{ url($config->image) }}">
<meta property="og:title" content="{{ $site_title ?? $title }}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ \URL::current() }}" />
<meta property="og:image" content="{{ url($config->image) }}" />
<meta property="og:description" content="{{ $site_description ?? $config->footer_text }}" />
<meta property="og:site_name" content="Cutie and Sweet (C&S) - Moda Fashion" />