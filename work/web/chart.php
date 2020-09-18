<style>
	.pie-chart {
		background:
			radial-gradient(
				circle closest-side,
				transparent 70%,
				white 0
			),
			conic-gradient(
        /* 継続中 */
				#E1E2D6ee 0,
        #E1E2D6ee <?=$p1;?>%,
        /* 役に立った！ */
				#DA471Dee 0,
        #DA471Dee <?=$p2;?>%,
        /* 挫折・不満.. */
				#90972eee 0,
				#90972eee 100%
		);
		position: relative;
		width: 300px;
		height: 150px;
		margin: 15px 34px 0 auto;
    outline: 1px solid #CCB86C77;
    /* border-color: #CCB86C;
    border-radius: 2px; */
	}
	.pie-chart cite {
    position: absolute;
    right:0px;
		bottom: 0;
		font-size: 80%;
		padding: 1rem;
		color: gray;
	}
	.pie-chart figcaption {
		position: absolute;
		bottom: 1em;
		right: 1em;
		font-size: smaller;
		text-align: right;
	}
	.pie-chart span:after {
		display: inline-block;
		content: "";
		width: 0.8em;
		height: 0.8em;
		margin-left: 0.4em;
		height: 0.8em;
		border-radius: 0.2em;
		background: currentColor;
	}
</style>
<figure class="pie-chart">
	<figcaption>
		継続 <?=$n1;?><span style="color:#E1E2D6ee"></span><br>
		役に立った！ <?=$n2;?><span style="color:#DA471Dee"></span><br>
		挫折・不満.. <?=$n3;?><span style="color:#90972eee"></span>
	</figcaption>
</figure>