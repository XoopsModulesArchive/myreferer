<div class="itemBody">
    <ul>
        <{foreach item=block from=$block.content}>
            <li><{$block.result}></li>
        <{/foreach}>
    </ul>
</div>
<div class="itemInfo" align="right"><{$block.more}></div>
