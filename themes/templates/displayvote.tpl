<h2>%QUESTION%</h2>
	<div class="flower">&nbsp;</div>
<form name="vote">
<input type="hidden" id="voteid" value="%QUESTIONID%" />
	<ul>
		<li><input type="radio" name="voteradio" class="styled" value="a1" />%ANSWER1%</li>
		<li><input type="radio" name="voteradio" class="styled" value="a2" />%ANSWER2%</li>
		<li style="display:%EXTRAANSWER3%;"><input type="radio" name="voteradio" class="styled" value="a3" />%ANSWER3%</li>
		<li style="display:%EXTRAANSWER4%;"><input type="radio" name="voteradio" class="styled" value="a4" />%ANSWER4%</li>
		<li style="display:%EXTRAANSWER5%;"><input type="radio" name="voteradio" class="styled" value="a5" />%ANSWER5%</li>
	</ul>
	<input type="button" onclick="placeVote()" value="Vote" />
</form>
<div id="resultDiv"></div>