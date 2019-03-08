/**
 * TODO: Dynamic import
 */
//Import library and DOM watcher from core package
import { library, dom } from '@fortawesome/fontawesome-svg-core'

/**
 * Setup required icons here in camel case, separated by packages
 * Choose only needed icons/packages
 */
import {
    faFacebook,
    faInstagram,
    faLinkedin,
    faTelegram,
    faTwitter,
    faYoutube,
    faGooglePlay
} from '@fortawesome/free-brands-svg-icons'

import {
    faQuoteRight as          faQuoteRightSolid,
    faQuoteLeft as           faQuoteLeftSolid,
    faHome as                faHomeSolid,
    faSearch as              faSearchSolid,
    faAngleLeft as           faAngleLeftSolid,
    faAngleDoubleLeft as     faAngleDoubleLeftSolid,
    faAngleDoubleRight as    faAngleDoubleRightSolid,
    faAngleRight as          faAngleRightSolid,
    faArrowLeft as           faArrowLeftSolid,
    faArrowRight as          faArrowRightSolid,
    faLongArrowAltLeft as    faLongArrowLeftSolid,
    faLongArrowAltRight as   faLongArrowRightSolid,
    faExclamationTriangle as faExclamationTriangleSolid,
    faCalendarAlt as         faCalendarAltSolid,
    faUser as                faUserSolid,
    faComment as             faCommentSolid,
    faEdit as                faEditSolid,
    faReply as               faReplySolid
} from '@fortawesome/free-solid-svg-icons' //change this to @fortawesome/pro-solid-svg-icons if you have license

// import {
// } from '@fortawesome/free-regular-svg-icons' //change this to @fortawesome/pro-regular-svg-icons if you have license

// //Comment this import statement if you haven't PRO license
// import {
//     faChevronLeft as faChevronLeftLight
//     ,faChevronRight as faChevronRightLight
// } from '@fortawesome/pro-light-svg-icons'

/**
 * Then include selected above icons in the library
 */
library.add(
    faFacebook,
    faInstagram,
    faLinkedin,
    faTelegram,
    faTwitter,
    faYoutube,
    faGooglePlay,

    faQuoteRightSolid,
    faQuoteLeftSolid,
    faHomeSolid,
    faSearchSolid,
    faAngleLeftSolid,
    faAngleRightSolid,
    faArrowLeftSolid,
    faArrowRightSolid,
    faAngleDoubleLeftSolid,
    faAngleDoubleRightSolid,
    faExclamationTriangleSolid,
    faCalendarAltSolid,
    faUserSolid,
    faCommentSolid,
    faLongArrowLeftSolid,
    faLongArrowRightSolid,
    faEditSolid,
    faReplySolid
)

// Replace any existing <i> tags with <svg> and set up a MutationObserver to
// continue doing this as the DOM changes.
dom.watch()

/**
 * All done! Type
 * npm run build
 * in the terminal and grab your bundle from dist folder
 */