<div class="item">

    <{include file="db:myreferer_head.tpl"}>

    <{if $numrows}>
        <div style="padding-bottom: 12px; text-align: center;" class="itemPermaLink"><{$nav_letters}></div>
        <table class="table">
            <tr>
                <td colspan="4">
                    <div class="itemPermaLink" align="right"><{$numrows}></div>
                </td>
            </tr>

            <div class="itemBody">
                <tr>
                </tr>

                <tr>
                    <td>
                        <{counter start=0 print=false}>
                        <{foreach item=info from=$infos}>
                        <{counter assign=count print=false}>
                        <{if $info.first_letter}>
                        <{if $count >= $limit}>
                    </td>
                    <td>
                        <{counter start=0 print=false}>
                        <{/if}>
                        <{/if}>
                        <{$info.first_letter}>
                        <nobr><{$info.visit}>&nbsp;
                            <a href="<{$info.page}>" target="_blank"><{$info.referer}></a>&nbsp;
                            <{$info.icon}><{$info.admins}></nobr>
                        <{/foreach}>
                    </td>
                </tr>
            </div>
        </table>
        <{if $admin}></p>
            <div class="itemFoot" align="right"><{$admin}></div>
        <{/if}>

    <{/if}>
</div>

<{include file="db:myreferer_foot.tpl"}>
