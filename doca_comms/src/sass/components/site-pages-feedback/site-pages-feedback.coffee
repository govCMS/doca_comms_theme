$ = @jQuery
document = @document
Drupal = @Drupal

@Drupal.behaviors.siteFeedback =
  attach: (context, settings) ->

    ###
    Site pages feedback.
    ###
    if settings.sitePagesFeedback? and settings.sitePagesFeedback['nid']?
      ###
      Options object.
      ###
      options =
        nid: settings.sitePagesFeedback['nid'] ? null
        sid: null
        token: null
        url: settings.currentPath ? window.location.href
        option: 0
        update: false

      ###
      Set data.
      ###
      setData = (key, value)->
        options[key] = value
        return

      ###
      Response callback.
      ###
      sendResponse = ->
        $(".site-feedback-block__inner .main", context).fadeOut("slow", ->
          $(".site-feedback-block__inner .message", context).fadeIn()
          return
        )
        return

      ###
      Open Popup window.
      ###
      sendPopup = ->
        $.magnificPopup.open({
          items: {
            preloader: true
            src: '#site-feedback-form'
            type: 'inline'
          }
        })
        return

      ###
      Ajax handler.
      ###
      sendData = ()->
        sendResponse()
        if options? and options.nid?
          url = location.protocol + "//" + location.host + settings.basePath + settings.pathToTheme + '/api/ajax/feedback/submit_simple.php'
          $.ajax url,
            type: 'POST'
            data: options
            success: (data) ->
              if data? and data.sid? and options.option == 0
                setData('sid', data.sid)
                $("input[name~='submitted[site_feedback_page_url]']").val(options.url);
                $("input[name~='submitted[site_feedback_helpful]']").val(0).prop("checked", true);
                $("input[name~='details[sid]']").val(data.sid);
                $("input[name~='site_feedback_sid']").val(data.sid);
                sendPopup()
              return
            error: (jqXHR) ->
              # console.log(jqXHR)
              return
        return

      ###
      Onclick event.
      ###
      $(".site-feedback-action", context).click (e)->
        e.preventDefault()
        option = $(this).data('spf-option') ? 0
        setData('option', option)
        sendData()
        return

    return
