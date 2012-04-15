<section>
            <header>
                <h2>{msgAdvancedSearch}</h2>
            </header>
    
            {printResult}
            
            <section class="well" id="searchBox">
            <form action="{writeSendAdress}" method="get" class="form-search">

                <div class="control-group">
                    <input id="searchfield" type="search" name="search" size="50" value="{searchString}"
                           class="input-xlarge search-query" autofocus="autofocus">
                    <input class="btn-primary" type="submit" name="submit" value="{msgSearch}" />
                    <input type="hidden" name="action" value="search" />
                    <label class="checkbox">
                    <input type="checkbox"{checkedAllLanguages} name="langs" id="langs" value="all" />
                    {searchOnAllLanguages}
                    </label>
                </div>

                <div class="control-group">
                    <label class="control-label">{selectCategories}</label>
                    <div class="controls">
                        <select name="searchcategory" size="1">
                        <option value="%" selected="selected">{allCategories}</option>
                        {printCategoryOptions}
                        </select>
                    </div>
                </div>
            </form>
            </section>
                
                <p id="mostpopularsearches">
                    <h4>{msgMostPopularSearches}</h4>
                    {printMostPopularSearches}
                </p>
                
                <p>{openSearchLink}</p>
        </section>