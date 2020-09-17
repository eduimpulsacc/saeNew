Ajax.Responders.register({
	onCreate: function() {
		if($('notification') && Ajax.activeRequestCount > 0)
			Effect.Appear('notification',{duration: 0.25, queue: 'end'});
	},
	onComplete: function() {
		if($('notification') && Ajax.activeRequestCount == 0)
			Effect.Fade('notification',{duration: 0.25, queue: 'end'});
	}
});