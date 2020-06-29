<{foreach item=data from=$block.data}>
    <{if $data.title}>
        <div class="item">
            <div class="itemHead"
            <span class="itemTitle"><{$data.title}></span>
        </div>
        <div class="itemBody">
            <ul>
                <{foreach item=item from=$data.result}>
                    <li><{$item}></li>
                <{/foreach}>
            </ul>
        </div>
        <div class="itemInfo" align="right"><{$data.more}></div>
        <br>
        </div>
    <{/if}>
<{/foreach}>
