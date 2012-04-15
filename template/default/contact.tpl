<h2>{msgContact}</h2>
            <p>{msgContactOwnText}</p>
            <p><strong>{msgContactEMail}</strong></p>

            <div id="loader"></div>
            <div id="contacts"></div>

            <form class="form-horizontal" id="formValues" action="#" method="post">
                <input type="hidden" name="lang" id="lang" value="{lang}" />

                <div class="control-group">
                    <label class="control-label" for="name">{msgNewContentName}</label>
                    <div class="controls">
                        <input type="text" name="name" id="name" value="{defaultContentName}" required="required" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="email">{msgNewContentMail}</label>
                    <div class="controls">
                        <input type="email" name="email" id="email" value="{defaultContentMail}" required="required" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="question">{msgMessage}</label>
                    <div class="controls">
                        <textarea cols="37" rows="5" name="question" id="question" required="required" /></textarea>
                    </div>
                </div>

                <div class="control-group">
                    {captchaFieldset}
                </div>

                <div class="form-actions">
                    <input class="btn-primary" type="submit" id="submitcontact" value="{msgS2FButton}" />
                </div>
            </form>
            <script type="text/javascript" >
            $(function() {
                $('#submitcontact').click(function() {
                    saveFormValues('sendcontact', 'contact');
                });
                $('form#formValues').submit(function() { return false; });
            });
            </script>
            
            <!-- DO NOT REMOVE THE COPYRIGHT NOTICE -->
            <div id="copyright">&copy; 2012 by <a href="mailto:myr-kat@bk.ru" target="_blank">Maria Rudko</a>. All rights reserved.</div>
            <!-- DO NOT REMOVE THE COPYRIGHT NOTICE -->
