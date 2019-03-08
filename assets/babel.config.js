module.exports = {
    presets: [
        [
            "@babel/env"
            ,{
                targets: {
                    browsers: [
                        "last 5 versions",
                        "ie >= 9"
                    ]
                }
                ,modules: false
            }
        ]
    ]
}