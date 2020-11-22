import * as express from 'express'
import { router as api_routes } from './api-routes'

export const application = express()

// SERVER SETUP
application.set('app_name', process.env.APP_NAME)
application.set('port', process.env.PORT || process.env.DEV_PORT)
application.use(express.json({ limit: '50mb' }))

// SERVER ROUTES
application.use(api_routes)
