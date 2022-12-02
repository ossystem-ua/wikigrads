<style>
.styled-select {
    position:relative;
    width: 340px;
    height: 45px;
    overflow: hidden;
    /*background: url(../images/down_arrow_select.jpg) no-repeat right #ddd;*/
    background: url(../images/bg-select.png) repeat-x;
    border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px;
    /* -moz-box-shadow: 0px 2px 0px #ffffff;-webkit-box-shadow: 0px 1px 0px #ffffff; */
}
    .styled-select-arrow {
        position:absolute;
        top:13px;
        right:10px;
        width:31px;
        height:19px;
        /*background: url(../images/down_arrow_select.jpg) no-repeat;*/
        background-image: url(../images/disclosure.png);
        background-position: 0 19px;
        z-index:500;
    }


.styled-select select {
    background: transparent;
    width: 368px;
    padding: 5px;
    border: none;
    font-size: 14px;
    height: 45px;
    -webkit-appearance: none;
    outline:none;
    font-family: Georgia,serif;
    z-index:5500;
}
</style>

<div class="content-pad">

<h1>MAIN -> DEV</h1>

    <form class="jqtransform">
        <div class="rowElem">
            <label for="name">Name: </label>
            <input type="text" name="name" />
        </div>

        <div class="rowElem">
            <select name="mychoice">
                <option value="1">this is something</option>
                <option value="2">what is the meaning of caow</option>
                <option value="3">you should not choose this</option>
                <option value="4">wow, that was awesome and really long</option>
                <option value="">my oho my dokiso odk owodj wjd iwjd</option>
                <option value="">my oho my dokiso odk owodj wjd iwjd</option>
                <option value="">my oho my dokiso odk owodj wjd iwjd</option>
                <option value="">my oho my dokiso odk owodj wjd iwjd</option>
                <option value="">my oho my dokiso odk owodj wjd iwjd</option>
                <option value="">my oho my dokiso odk owodj wjd iwjd</option>
                <option value="">my oho my dokiso odk owodj wjd iwjd</option>
                <option value="">my oho my dokiso odk owodj wjd iwjd</option>
                <option value="">my oho my dokiso odk owodj wjd iwjd</option>
                <option value="">my oho my dokiso odk owodj wjd iwjd</option>
                <option value="">my oho my dokiso odk owodj wjd iwjd</option>
                <option value="">my oho my dokiso odk owodj wjd iwjd</option>
                <option value="">my oho my dokiso odk owodj wjd iwjd</option>
                <option value="">my oho my dokiso odk owodj wjd iwjd</option>
                <option value="">my oho my dokiso odk owodj wjd iwjd</option>
                <option value="">my oho my dokiso odk owodj wjd iwjd</option>
                <option value="">my oho my dokiso odk owodj wjd iwjd</option>
            </select>
        </div>
        
        <div class="rowElem">
            <input type="file" name="myfile" />
        </div>
        
        <div class="rowElem">
            <input type="submit" value="send" />
        <div>
    </form>
</div>
