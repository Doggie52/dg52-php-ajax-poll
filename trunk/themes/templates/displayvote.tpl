<h1 class="header">%QUESTION%</h1>
<form name="vote">
<input type="hidden" id="voteid" value="%QUESTIONID%" />
	<ul>
		<li><input type="radio" name="voteradio" value="a1" />%ANSWER1%</li>
		<li><input type="radio" name="voteradio" value="a2" /><p>%ANSWER2%</p></li>
		<li style="display:%EXTRAANSWER3%;"><input type="radio" name="voteradio" value="a3" />%ANSWER3%</li>
		<li style="display:%EXTRAANSWER4%;"><input type="radio" name="voteradio" value="a4" />%ANSWER4%</li>
		<li style="display:%EXTRAANSWER5%;"><input type="radio" name="voteradio" value="a5" />%ANSWER5%</li>
	</ul>
	<input type="button" onclick="placeVote()" value="Vote" class="submit"/>
</form>
<div id="resultDiv"></div>