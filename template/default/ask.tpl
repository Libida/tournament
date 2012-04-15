<h2>{msgQuestion}</h2>

            <div id="questionForm">
                <p>{msgNewQuestion}</p>
            </div>
            <div id="answerForm"></div>
            <div id="answers"></div>

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
                    <label class="control-label" for="category">{msgAskCategory}</label>
                    <div class="controls">
                        <select name="category" id="category" required="required" />
                        {printCategoryOptions}
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="question">{msgAskYourQuestion}</label>
                    <div class="controls">
                        <textarea cols="45" rows="5" name="question" id="question" required="required" /></textarea>
                    </div>
                </div>

                <div class="control-group">
                    {captchaFieldset}
                </div>

                <div id="loader"></div>
                <div id="qerror"></div>

                <div class="form-actions">
                    <input class="btn-primary" type="submit" id="submitquestion" value="{msgNewContentSubmit}">
                </div>

            </form>

            <script type="text/javascript" >
            $(function() {
                $('#submitquestion').click(function() {
                    checkQuestion();
                });
                $('form#formValues').submit(function() { return false; });
            });
            </script>