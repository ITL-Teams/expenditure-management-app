type AuthStatus = 'OK' | 'FAILED'

export type TwoFactorValidatorResponse = {
  status: AuthStatus
  user_data?: {
    user_id: string
    enterprise_account: boolean
  }
}
