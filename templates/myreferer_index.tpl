<div class="item">

    <{include file="db:myreferer_head.html"}>

    <{if $numrows}>
        <table class="table">
            <tr>
                <td colspan="4">
                    <{if $pagenav}>
                        <div class="itemPermaLink"><{$pages}><{$pagenav}></div><{/if}>
                </td>
                <td colspan="2">
                    <div class="itemPermaLink" align="right"><{$numrows}></div>
                </td>
            </tr>
            <div class="itemBody">
                <tr>
                    <th> N�</th>
                    <th><a href="<{$navlink}>&ord=referer">    <{$current}></a></th>
                    <th>    <{$page}>                                </th>
                    <th><a href="<{$navlink}>&ord=visit">    <{$visit}>    </a></th>
                    <th><a href="<{$navlink}>&ord=date">    <{$date}>    </a></th>
                    <th>    <{$icon}>                                </th>

                </tr>

                <{foreach item=info from=$infos}>
                    <tr class="<{cycle values="even,odd"}>">
                        <td align="center">
                            <{$info.count}>
                        </td>

                        <td>
                            <{if $info.ref_url}>
                                <a href="<{$info.ref_url}>" title="<{$info.alt_referer}>" target="_blank"><{$info.referer}></a>
                            <{else}>
                                <{$info.referer}>
                            <{/if}>
                        </td>

                        <td align="center">
                            <{if $info.page}>
                                <a href="<{$info.page}>" target="_blank"><img src="images/icon/view.gif" alt="<{$info.page}>"></a>
                            <{else}>
                                /
                            <{/if}>
                        </td>

                        <td align="center">
                            <{$info.visit}>
                        </td>

                        <td align="center">
                            <{$info.date}>
                        </td>

                        <td align="center">
                            <{$info.icon}>
                        </td>
                    </tr>
                <{/foreach}>
            </div>
        </table>
        <{if $pagenav}>
            <p>
            <div align="right" class="itemPermaLink"><{$pages}><{$pagenav}></div>
            <p>
        <{/if}>

        <{if $admin}></p>
            <div class="itemFoot" align="right"><{$admin}></div>
        <{/if}>

    <{/if}>
</div>

<{include file="db:myreferer_foot.html"}>
