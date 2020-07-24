<div id="ad_sense_module">
    
    {if $switch_status}
        
        {if $ad_image}

            {* Banner con imagen personalizada *}

            <div id="custom_banner" class="custom_dark">
                <div class="left">
                    <h1 class="ad_title">{l s= $ad_title mod='gradiadsense'}</h1><br>
                    <h4 class="italic">{$ad_description}</h4>
                </div>
                <div class="right">
                    <img src="/tienda/modules/gradiadsense/img/{$ad_image}">
                </div>
                <a id="custom_cta" href="{$cta_url}" target="_blank">{$cta_label}</a>
            </div>
        {else}

            {* Banner con imagen Por defecto *}

            <div id="default_banner" class="light">
                <div class="left">
                    <h1 class="ad_title">{l s= $ad_title mod='gradiadsense'}</h1><br>
                    <h4 class="italic">{$ad_description}</h4>
                </div>
                <div class="right">
                    <img src="/tienda/modules/gradiadsense/img/second_xbox.png">
                </div>
                <a id="default_cta" href="{$cta_url}" target="_blank">{$cta_label}</a>
            </div>
    {/if}

    {else}
       <h2>La publicidad ha sido deshabilitada temporalmente</h2> 
    {/if}
    
</div>