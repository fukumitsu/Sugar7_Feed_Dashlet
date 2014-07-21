({
    plugins: ['Dashlet'],
    initDashlet: function() {
        if(this.meta.config) {
            var limit = this.settings.get("limit") || "5";
            this.settings.set("limit", limit);
        }
        this.model.on("change:feed_url_c", this.loadData, this);
    },
    loadData: function (options) {
        var website, limit;

        if(_.isUndefined(this.model)){
            return;
        }
        var self = this;
        var rssUrl = app.api.buildURL('RSS/GetItems',null,null,{website:this.model.get('feed_url_c'),limit:this.settings.get('limit')});
        app.api.call('get', rssUrl, null,{

            success: function (data) {
                if (this.disposed) {
                    return;
                }
                console.log(data);
                _.extend(self, data);
                self.render();
            },
        });
    }
})
