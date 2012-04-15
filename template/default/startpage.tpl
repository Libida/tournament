        [socialLinks]
        <section class="well">
            <div id="social">
                <a href="{link_facebook}" target="_blank">
                    <img src="images/facebook.png" alt="{writeFacebookMsgTag}" title="{writeFacebookMsgTag}" width="32" height="32" border="0" />
                </a>
                <a href="{link_twitter}" target="_blank">
                    <img src="images/twitter.png" alt="{writeTwitterMsgTag}" title="{writeTwitterMsgTag}" width="32" height="32" border="0" />
                </a>
                <a href="{link_delicious}" target="_blank">
                    <img src="images/delicious.png" alt="{writeDeliciousMsgTag}" title="{writeDeliciousMsgTag}" width="32" height="32" border="0" />
                </a>
                <a href="{link_digg}" target="_blank">
                    <img src="images/digg.png" alt="{writeDiggMsgTag}" title="{writeDiggMsgTag}" width="32" height="32" border="0" />
                </a>
                <a href="{link_email}">
                    <img src="images/email.png" alt="{writeSend2FriendMsgTag}" title="{writeSend2FriendMsgTag}" width="32" height="32" border="0" />
                </a>
                <a target="_blank" href="{link_pdf}">
                    <img src="images/pdf.png" alt="{writePDFTag}" title="{writePDFTag}" width="32" height="32" border="0" />
                </a>
                <a href="javascript:window.print();">
                    <img src="images/print.png" alt="{writePrintMsgTag}" title="{writePrintMsgTag}" width="32" height="32" border="0" />
                </a>
            </div>
            <div id="facebookLikeButton">
                {facebookLikeButton}
            </div>
        </section>
        [/socialLinks]
        <section class="well">
            <header>
                <h3>{writeTopTenHeader} <a href="feed/topten/rss.php" target="_blank"><img src="images/feed.png" width="16" height="16" alt="RSS" /></a></h3>
            </header>
            <ol>
                [toptenList]
                <li><a href="{toptenUrl}">{toptenTitle}</a> ({toptenVisits})</li>
                [/toptenList]
                [toptenListError]
                <li>{errorMsgTopTen}</li>
                [/toptenListError]
            </ol>
        </section>

        <section class="well">
            <header>
                <h3>{writeNewestHeader} <a href="feed/latest/rss.php" target="_blank"><img src="images/feed.png" width="16" height="16" alt="RSS" /></a></h3>
            </header>
            <ol>
                [latestEntriesList]
                <li><a href="{latestEntriesUrl}">{latestEntriesTitle}</a> ({latestEntriesDate})</li>
                [/latestEntriesList]
                [latestEntriesListError]
                <li>{errorMsgLatest}</li>
                [/latestEntriesListError]
            </ol>
        </section>